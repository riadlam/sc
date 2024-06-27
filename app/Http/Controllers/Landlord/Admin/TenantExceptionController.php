<?php

namespace App\Http\Controllers\Landlord\Admin;

use App\Actions\Tenant\ReGenerateTenant;
use App\Helpers\FlashMsg;
use App\Helpers\ResponseMessage;
use App\Helpers\SanitizeInput;
use App\Http\Controllers\Controller;
use App\Models\TenantException;
use App\Models\Testimonial;
use App\Models\Themes;
use Illuminate\Http\Request;
use App\Models\PaymentLogs;
use App\Models\Tenant;
use App\Helpers\Payment\DatabaseUpdateAndMailSend\LandlordPricePlanAndTenantCreate;
use DB;
use Stancl\Tenancy\Jobs;
use Illuminate\Support\Facades\Artisan;


class TenantExceptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function website_issues()
    {
        $all_issues = TenantException::where(['domain_create_status'=> 0, 'seen_status' => 0])->get();
        return view('landlord.admin.user-website-issues.all-issues', compact('all_issues'));
    }

    public function generate_domain(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        $id = $request->id;
        $exception = TenantException::findOrFail($id);
        $tenant = Tenant::find($exception->tenant_id);
        $payment_log = PaymentLogs::where('tenant_id', $tenant->id)->first();

        $validated = [
            'account_status' => $payment_log->status,
            'subs_tenant_id' => $tenant->id
        ];

        $reassign_object = new ReGenerateTenant($validated);
        $response = $reassign_object->regenerateTenant();

        if (!empty($response))
        {
            return back()->withErrors($response);
        }

        return back()->with(FlashMsg::explain('success', 'Tenant Regenerated successfully'));
    }

    public function manual_database(Request $request)
    {
        $request->validate([
            'database_name' => 'required|string|max:191',
            'exception_id' => 'required'
        ]);

        $id = $request->exception_id;
        $manual_database = trim($request->database_name);

        $exception = TenantException::findOrFail($id);
        $tenant = Tenant::find($exception->tenant_id);

        if(is_null($tenant)){
            return response()->danger(__('Tenant did not found'));
        }


        if(!empty($tenant) && $tenant->id == $manual_database){
            return response()->danger(__('Database exists with this name'));
        }


        $payment_log = PaymentLogs::where('tenant_id',$tenant->id)->first();
        if(is_null($payment_log)){
            return response()->danger(__('tenant payment log not found'));
        }

        $payment_data = [];
        $payment_data['order_id'] = $payment_log->id;
        LandlordPricePlanAndTenantCreate::update_tenant($payment_data); //tenant table user_id update and expired date update
        LandlordPricePlanAndTenantCreate::update_database($payment_log->id, $payment_log->transaction_id); //update payment log  information with transaction id

        try{
            $current_tenant = DB::table('tenants')->where('id',$tenant->id)->first();
            $format = (array) json_decode($current_tenant->data);
            $format['tenancy_db_name'] = $manual_database;
            DB::table('tenants')->where('id',$tenant->id)->update(['data'=> json_encode($format)]);


        }catch(\Exception $e){

            // todo check str_contains database exists
            $message = $e->getMessage();


            if(\str_contains($message,'Access denied')){
                return response()->danger(__('Wrong database or your user privilege has not been set'));
            }


            if(\str_contains($message,'database exists')){
                return response()->danger(__('Data already Exists'));
            }

        }

        try{
            $tenant->domains()->create(['domain' => $tenant->getTenantKey().'.'.getenv('CENTRAL_DOMAIN')]);
        }catch(\Exception $e){
            $message = $e->getMessage();
            if(!str_contains($message,'occupied by another tenant')){
                return response()->danger(__('subdomain create failed'));
            }
        }

        try{
            //database migrate
            $command = 'tenants:migrate --force --tenants='.$tenant->id;
            Artisan::call($command);
        }catch(\Exception $e){
            return response()->danger(__('tenant database migrate failed'));
        }

        try{
            Artisan::call('tenants:seed', [
                '--tenants' => $tenant->getTenantKey(),
                '--force' => true
            ]);

            $exception->domain_create_status = 1;
            $exception->seen_status = 1;
            $exception->save();

            LandlordPricePlanAndTenantCreate::tenant_create_event_with_credential_mail($payment_log->id,false);
            LandlordPricePlanAndTenantCreate::send_order_mail($payment_log->id);

            return response()->success(ResponseMessage::SettingsSaved('Database and domain create success'));


        }catch(\Exception $e){

            //Duplicate entry
            $message = $e->getMessage();
            if(str_contains($message,'Duplicate entry')){
                $exception->domain_create_status = 1;
                $exception->seen_status = 1;
                $exception->save();
                return response()->danger(__('tenant database demo data already imoported'));

            }
            return response()->danger(__('tenant database demo data import failed'));
        }

        $exception->domain_create_status = 1;
        $exception->seen_status = 1;
        $exception->save();

        LandlordPricePlanAndTenantCreate::tenant_create_event_with_credential_mail($payment_log->id,false);
        LandlordPricePlanAndTenantCreate::send_order_mail($payment_log->id);
        return response()->success(ResponseMessage::SettingsSaved('Database and domain create success'));
    }
}
