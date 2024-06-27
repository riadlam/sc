<?php

namespace App\Http\Middleware\Tenant;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenantUserMailVerifyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('web')->user();
        if (get_static_option('user_email_verify_status') && $user->email_verified == 0){
                return redirect()->route('tenant.user.email.verify');
        }
        return $next($request);
    }
}
