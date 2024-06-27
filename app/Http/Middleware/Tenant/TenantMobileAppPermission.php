<?php

namespace App\Http\Middleware\Tenant;

use Closure;
use Illuminate\Http\Request;

class TenantMobileAppPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $current_tenant_payment_data = tenant()->payment_log ?? []; // Getting the tenant payment log

        if (!empty($current_tenant_payment_data)) // If the tenant subscribed to any plan and if the route has the permission name
        {
            $package = $current_tenant_payment_data?->package;

            if (!empty($package))
            {
                $features = $package?->plan_features?->pluck('feature_name')->toArray();
                $permission = in_array('app_api', (array)$features);
                if (!$permission)
                {
                    return response()->json(['msg' => 'no permission'])->setStatusCode(403);
                }
            }
        }

        return $next($request);
    }
}
