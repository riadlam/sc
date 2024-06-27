<?php

namespace App\Actions\Tenant;

use App\Enums\PricePlanTypEnums;
use App\Helpers\FlashMsg;
use App\Helpers\Payment\DatabaseUpdateAndMailSend\LandlordPricePlanAndTenantCreate;
use App\Helpers\ResponseMessage;
use App\Helpers\SanitizeInput;
use App\Models\PaymentLogs;
use App\Models\PricePlan;
use App\Models\Tenant;
use App\Models\TenantException;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ReGenerateTenant
{
    private array $validated;

    public function __construct($validated)
    {
        $this->validated = $validated;
    }

    public function getUser()
    {
        $user_id = null;
        $payment_log = $this->getUserPaymentLog();
        if (!empty($payment_log)) // If tenant has payment log with user id
        {
            $user_id = $payment_log->user_id;
        }

        if (empty($user_id)) // If tenant does not have payment log or payment log with no user id
        {
            if (!array_key_exists('user', $this->validated)) // If user is not selected
            {
                return back()->with(FlashMsg::explain('danger', 'User field is required.'));
            }
            $user_id = (int)$this->validated['user'];
        }

        return $user_id;
    }

    public function regenerateTenant()
    {
        $response = [];
        $tenant = $this->getTenant();

        if(empty($tenant)){
            return __('Tenant not found');
        }

        $payment_log = PaymentLogs::where('tenant_id',$tenant->id)->first();
        if(is_null($payment_log)){
            return __('tenant payment log not found');
        }

        $payment_log = $this->modifyPaymentLog($payment_log);

        $payment_data = [];
        $payment_data['order_id'] = $payment_log->id;
        LandlordPricePlanAndTenantCreate::update_tenant($payment_data); //tenant table user_id update and expired date update
        LandlordPricePlanAndTenantCreate::update_database($payment_log->id, $payment_log->transaction_id); //update payment log  information with transaction id

        $this->modifyTenantData($tenant);

        try{
            $this->createDatabase($tenant);

        }catch(\Exception $e){

            //todo check str_contains database exists
            $message = $e->getMessage();

            if(!\str_contains($message,'database exists')){
                $error_msg = __('Database created failed, Make sure your database user has permission to create database');
                $response[] = $error_msg;
                LandlordPricePlanAndTenantCreate::store_exception($tenant->id, 'database exists', $error_msg, 0);
            }

            if(\str_contains($message,'database exists')){
                $error_msg = __('Data already Exists');
                $response[] = $error_msg;
                LandlordPricePlanAndTenantCreate::store_exception($tenant->id, 'database exists', $error_msg, 0);
            }
        }

        try{
            $this->createDomain($tenant);
        }catch(\Exception $e){
            $message = $e->getMessage();
            if(!str_contains($message, 'occupied by another tenant')){
                $error_msg = __('subdomain create failed');
                $response[] = $error_msg;
                LandlordPricePlanAndTenantCreate::store_exception($tenant->id, 'occupied by another tenant', $error_msg, 0);
            }
        }

        try{
            //database migrate
            $this->migrateDatabase($tenant);
        }catch(\Exception $e){
            $error_msg = __('tenant database migrate failed');
            $response[] = $error_msg;
            LandlordPricePlanAndTenantCreate::store_exception($tenant->id, 'tenant database migrate failed', $error_msg, 0);
        }

        try{
            Artisan::call('tenants:seed', [
                '--tenants' => $tenant->getTenantKey(),
                '--force' => true
            ]);

            TenantException::updateOrCreate(
                [
                    'tenant_id' => $tenant->id
                ],
                [
                    'domain_create_status' => 1,
                    'seen_status' => 1
                ]
            );
        }catch(\Exception $e){

            //Duplicate entry
            $message = $e->getMessage();
            if(str_contains($message,'Duplicate entry')){
                $error_msg = __('tenant database demo data already imported');
                $response[] = $error_msg;
                LandlordPricePlanAndTenantCreate::store_exception($tenant->id, 'duplicate entry', $error_msg, 1);
            }
            //todo, tested in user shared hosting website...
            //this code is work fine in shared hosting, without change of database engine

            if(str_contains($message,'Connection could not be established with host')){
                $error_msg = __('tenant database migrate and import success and website is ready to use, mail not send to user because your smtp not working.');
                $response[] = $error_msg;
                LandlordPricePlanAndTenantCreate::store_exception($tenant->id, 'connection could not be established with host', $error_msg, 1);
            }
        }

        return $response;
    }

    public function modifyTenant(): bool
    {
        $tenant = $this->getTenant();
        $user_id = $this->getUser();
        $payment_log = $this->getUserPaymentLog();
        $package = $this->getPackage();


        return \DB::table('tenants')->where('id', $tenant->id)->update([
            'user_id' => $user_id,
            'theme_slug' => $payment_log->theme_slug,
            'start_date' => $package['package_start_date'],
            'expire_date' => $package['package_expire_date'],
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function getTenant()
    {
        $tenant_id = $this->validated['subs_tenant_id'];
        return Tenant::find($tenant_id);
    }

    public function createOrModifyPaymentLog()
    {
        $user_id = $this->getUser();
        $user = User::find($user_id);

        $theme_slug = $this->validated['custom_theme'];
        $tenant_id = $this->validated['subs_tenant_id'];
        $payment_status = $this->validated['payment_status'];
        $account_status = $this->validated['account_status'];

        $package = $this->getPackage();

        PaymentLogs::updateOrCreate([
            'user_id' => $user_id,
            'tenant_id' => $tenant_id
        ], [
            'email' => $user->email,
            'name' => $user->name,
            'package_name' => $package['package']->title,
            'package_price' => $package['package']->price,
            'package_gateway' => null,
            'package_id' => $package['package']->id,
            'user_id' => $user->id,
            'tenant_id' => $tenant_id,
            'theme_slug' => $theme_slug,
            'is_renew' => 0,
            'payment_status' => $payment_status,
            'status' => $account_status,
            'track' => Str::random(10) . Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'start_date' => $package['package_start_date'],
            'expire_date' => $package['package_expire_date'],
        ]);
    }

    public function createDomain($tenant)
    {
        return $tenant->domains()->create(['domain' => $tenant->getTenantKey().'.'.env('CENTRAL_DOMAIN')]);
    }

    private function modifyTenantData($tenant)
    {
        if (is_null($tenant->data))
        {
            \DB::table('tenants')->where('id', $tenant->id)->update([
                'data' => $this->getInsertableDatabaseName()
            ]);
        }
    }

    public function createDatabase($tenant)
    {
        return $tenant->database()->manager()->createDatabase($tenant);
    }

    public function migrateDatabase($tenant)
    {
        $command = 'tenants:migrate --force --tenants='.$tenant->id;
        Artisan::call($command);
    }

    private function getPackage(): array
    {
        $payment_log = $this->getUserPaymentLog();
        $package_id = !empty($payment_log) ? $payment_log->package_id : $this->validated['package'];

        $package = Cache::remember('package_plan', 60, function () use ($package_id) {
            return PricePlan::findOrFail($package_id);
        });

        $package_start_date = '';
        $package_expire_date = '';
        if (!empty($package)) {
            if ($package->type == PricePlanTypEnums::MONTHLY) { //monthly
                $package_start_date = Carbon::now()->format('d-m-Y h:i:s');
                $package_expire_date = Carbon::now()->addMonth()->format('d-m-Y h:i:s');

            } elseif ($package->type == PricePlanTypEnums::YEARLY) { //yearly
                $package_start_date = Carbon::now()->format('d-m-Y h:i:s');
                $package_expire_date = Carbon::now()->addYear()->format('d-m-Y h:i:s');
            } else { //lifetime
                $package_start_date = Carbon::now()->format('d-m-Y h:i:s');
                $package_expire_date = null;
            }
        }

        if (!empty($payment_log) && $payment_log->status == 'trial')
        {
            $package_expire_date = Carbon::now()->addDays($payment_log->trial_days);
        }

        return [
            'package' => $package,
            'package_start_date' => $package_start_date,
            'package_expire_date' => $package_expire_date
        ];
    }

    private function getUserPaymentLog()
    {
        return PaymentLogs::where('tenant_id', $this->validated['subs_tenant_id'])->latest()->first();
    }

    private function modifyPaymentLog($payment_log)
    {
        $user_id = $this->getUser();
        $user = User::find($user_id);

        if (is_null($payment_log->email))
        {
            $payment_log->email = $user->email;
        }

        if (is_null($payment_log->name))
        {
            $payment_log->name = $user->name;
        }

        $payment_log->save();

        return $payment_log;
    }

    private function getInsertableDatabaseName()
    {
        $database_name = array_key_exists('database_name', $this->validated) ? $this->validated['database_name'] : ($this->getTenant())->id;
        return '{"tenancy_db_name":' . json_encode(env('TENANT_DATABASE_PREFIX').SanitizeInput::esc_html(trim($database_name))) . '}';
    }
}
