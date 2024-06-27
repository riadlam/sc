<?php

namespace Database\Seeders\Tenant;

use App\Jobs\PlaceOrderMailJob;
use App\Jobs\TenantCredentialJob;
use App\Mail\TenantCredentialMail;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AdminSeed extends Seeder
{
    public function run()
    {
        $raw_pass = get_static_option_central('tenant_admin_default_password') ?? '12345678';
            $admin = Admin::create([
                'name' => 'Super Admin',
                'username' => get_static_option_central('tenant_admin_default_username') ?? 'super_admin',
                'email' => 'super@admin.com',
                'password' => Hash::make($raw_pass),
            ]);

            $admin->assignRole('Super Admin');
    }
}
