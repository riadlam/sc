<?php

namespace App\Actions\Tenant;

use App\Enums\PricePlanTypEnums;
use App\Helpers\FlashMsg;
use App\Helpers\SanitizeInput;
use App\Models\PaymentLogs;
use App\Models\PricePlan;
use App\Models\Tenant;
use App\Models\User;
use http\Env\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ReassignTenant
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
        $exception_message = [];

//        try {
//            $this->modifyTenant();
//            $this->createOrModifyPaymentLog();
//        } catch (\Exception $exception) {}

        $tenant = $this->getTenant();
//
//        try {
//            $tenant->database()->manager()->createDatabase($tenant);
//        } catch(\Exception $e) {
//
//            //todo check str_contains database exists
//            $message = $e->getMessage();
//
//            if(!\str_contains($message,'database exists')){
//                $exception_message[] = __('Database created failed, Make sure your database user has permission to create database');
//            }
//
//            if(\str_contains($message,'database exists')){
//                $exception_message[] = __('Data already Exists');
//            }
//        }
//
//        try{
//            $this->createDomain();
//        } catch(\Exception $e) {
//            $message = $e->getMessage();
//            if(!str_contains($message,'occupied by another tenant')){
//                $exception_message[] = __('subdomain create failed');
//            }
//        }
//
//        try{
//            //database migrate
//            $command = 'tenants:migrate --force --tenants='.$tenant->id;
//            Artisan::call($command);
//        } catch(\Exception $e) {
//            $exception_message[] = __('tenant database migrate failed');
//        }
//
////        try{
//            Artisan::call('tenants:seed', [
//                '--tenants' => $tenant->getTenantKey(),
//                '--force' => true
//            ]);

        dd(121212);

//            $exception->domain_create_status = 1;
//            $exception->seen_status = 1;
//            $exception->save();
//
//            LandlordPricePlanAndTenantCreate::tenant_create_event_with_credential_mail($payment_log->id,false);
//            LandlordPricePlanAndTenantCreate::send_order_mail($payment_log->id);
//
//            return response()->success(ResponseMessage::SettingsSaved('Database and domain create success'));


//        }catch(\Exception $e){
//
//            dd($e->getMessage());
//
//            //Duplicate entry
//            $message = $e->getMessage();
//            if(str_contains($message,'Duplicate entry')){
//                $exception->domain_create_status = 1;
//                $exception->seen_status = 1;
//                $exception->save();
//                return response()->danger(__('tenant database demo data already imported'));
//
//            }
//            //todo, tested in user shared hosting website...
//            //this code is work fine in shared hosting, without change of database engine
//
//            if(str_contains($message,'Connection could not be established with host')){
//                return response()->success(__('tenant database migrate and import success and website is ready to use, mail not send to user because your smtp not working.'));
//            }
//        }
    }

    public function modifyTenant(): bool
    {
        $user_id = $this->getUser();
        $theme_slug = $this->validated['custom_theme'];
        $tenant_id = $this->validated['subs_tenant_id'];

        $package = $this->getPackage();

        return \DB::table('tenants')->where('id', $tenant_id)->update([
            'user_id' => $user_id,
            'theme_slug' => $theme_slug,
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

    public function createDomain()
    {
        $tenant = $this->getTenant();
        $tenant->domains()->create(['domain' => $tenant->getTenantKey().'.'.env('CENTRAL_DOMAIN')]);
    }

    private function getPackage(): array
    {
        $package = Cache::remember('package_plan', 60, function () {
            return PricePlan::findOrFail($this->validated['package']);
        });

        $package_start_date = '';
        $package_expire_date = '';
        if (!empty($package)) {
            if ($package->type == PricePlanTypEnums::MONTHLY) { //monthly
                $package_start_date = Carbon::now()->format('d-m-Y h:i:s');
                $package_expire_date = Carbon::now()->addMonth(1)->format('d-m-Y h:i:s');

            } elseif ($package->type == PricePlanTypEnums::YEARLY) { //yearly
                $package_start_date = Carbon::now()->format('d-m-Y h:i:s');
                $package_expire_date = Carbon::now()->addYear(1)->format('d-m-Y h:i:s');
            } else { //lifetime
                $package_start_date = Carbon::now()->format('d-m-Y h:i:s');
                $package_expire_date = null;
            }
        }

        $payment_log = $this->getUserPaymentLog();
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

//    private function getInsertableDatabaseName()
//    {
//        $database_name = $this->validated['database_name'];
//        return '{"tenancy_db_name":' . json_encode(SanitizeInput::esc_html(trim($database_name))) . '}';
//    }
}
