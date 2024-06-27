<?php

namespace App\Listeners;

use App\Events\TenantRegisterEvent;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;

class TenantDomainCreate
{

    public function __construct()
    {

    }

    public function handle(TenantRegisterEvent $event)
    {
        $tenant = Tenant::create(['id' => $event->subdomain]);
        DB::table('tenants')->where('id', $tenant->id)->update(['user_id' => $event->user_info->id, 'theme_slug' => $event->theme]);
        $tenant->domains()->create(['domain' => $event->subdomain . '.' . env('CENTRAL_DOMAIN')]);
    }
}
