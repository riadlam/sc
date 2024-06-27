<?php

namespace App\Console\Commands;

use App\Events\TenantCronjobEvent;
use App\Mail\BasicMail;
use App\Models\PaymentLogs;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PackageExpireCommand extends Command
{

    protected $signature = 'package:expire';
    protected $description = 'Command description';
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $all_user = \App\Models\User::all();

        foreach ($all_user as $user){

            $table_user  = $user->tenant_details ?? '';

            foreach ($table_user as $table_user_id)
            {
                if(!empty($table_user_id)){
                    $payment_log = \App\Models\PaymentLogs::where(['tenant_id' => $table_user_id->id, 'payment_status' => 'complete'])->whereDate('expire_date','>=',Carbon::today())->first();

                    if (is_null($payment_log)){
                        continue;
                    }

                    $day_list = json_decode(get_static_option('package_expire_notify_mail_days')) ?? [];
                    rsort($day_list);


                    $cron_qty = 0;
                    foreach ($day_list as $day){
                        $startDate = Carbon::today();
                        $notification_date = \Carbon\Carbon::parse($payment_log->expire_date)->subDay($day);
                        $compareDays = $notification_date->lt($startDate);

                        if ($compareDays){

                            $days_reaming = $startDate->diffInDays(\Carbon\Carbon::parse($payment_log->expire_date));

                            $message['subject'] = 'Subscription Will Expire - ' . get_static_option('site_title');
                            $message['body'] = 'Your Subscription will expire very soon. Only ' . ($days_reaming) . ' Days Left. Please subscribe to a plan before expiration';
                            Mail::to($payment_log->email)->send(new \App\Mail\BasicMail($message['body'], $message['subject']));


//                        //Cronjob Store Event
//                        $event_data = [
//                            'id' =>  $payment_log->id,
//                            'title' =>  __('Package Expire Cronjob'),
//                            'type' =>  'package_expire',
//                            'running_qty' =>  $cron_qty + 1,
//                        ];
//                        event(new \App\Events\TenantCronjobEvent($event_data));
//                        //Cronjob Store Event

                            break;
                        }

                    }
                }
            }
        }


        return 0;
    }
}
