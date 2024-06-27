<?php

namespace App\Http\Middleware\Tenant;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenantCheckPermission
{
    public function handle(Request $request, Closure $next)
    {
        $routeName = \Route::currentRouteName();
        $routeArr = explode('.',$routeName); // Exploding the hit route name in array

        $name = $this->getName($routeArr); // Getting the permission name from the route name array

        $current_tenant_payment_data = tenant()->payment_log ?? []; // Getting the tenant payment log

        if (!empty($current_tenant_payment_data) && !empty($name)) // If the tenant subscribed to any plan and if the route has the permission name
        {
            $package = $current_tenant_payment_data->package;

            if (!empty($package))
            {
                $features = $package->plan_features->pluck('feature_name')->toArray();

                if (in_array($name, (array)$features))
                {
                    return $next($request);
                }
            }
        }

        return redirect(url('admin'));
    }

    private function getName($routeArr)
    {
        $name = '';

        // Route name based feature search
        if (in_array('coupon', $routeArr))
        {
            $arrKey = array_search('coupon', $routeArr);
            if ($arrKey == 3) // In route name the coupon feature name always in index 3
            {
                $name = $routeArr[$arrKey];
            }
        }

        if (in_array('inventory', $routeArr))
        {
            $arrKey = array_search('inventory', $routeArr);
            if ($arrKey == 3) // In route name the inventory feature name always in index 3
            {
                $name = $routeArr[$arrKey];
            }
        }

        if (in_array('campaign', $routeArr))
        {
            $arrKey = array_search('campaign', $routeArr);
            if ($arrKey == 2) // In route name the campaign feature name always in index 2
            {
                $name = $routeArr[$arrKey];
            }
        }

        if (in_array('newsletter', $routeArr))
        {
            $arrKey = array_search('newsletter', $routeArr);
            if ($arrKey == 2) // In route name the newsletter feature name always in index 2
            {
                $name = $routeArr[$arrKey];
            }
        }

        if (in_array('testimonial', $routeArr))
        {
            $arrKey = array_search('testimonial', $routeArr);
            if ($arrKey == 2) // In route name the testimonial feature name always in index 2
            {
                $name = $routeArr[$arrKey];
            }
        }


        // URL based feature search
        $full_url = \URL::current(); // Getting full url
        $nameFromUrlArray = explode('/', $full_url); // url into array to get the permission name
        if (in_array('custom-domain', $nameFromUrlArray))
        {
            $arrKey = array_search('custom-domain', $nameFromUrlArray);
            if ($arrKey == 4) // In url the custom-domain feature name always in index 4
            {
                $name = str_replace('-','_',$nameFromUrlArray[$arrKey]);
            }
        }

        return $name;
    }
}
