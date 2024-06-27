<?php

namespace Modules\Product\Http\Traits;

trait ProductSearchTrait
{
    public static function productSearch($request, $req_route = null, $queryType = "admin"): array
    {
        $route = null;

        if(\Auth::guard('admin')->check()){
            $route = "admin";
        }else {
            $route = "api";
        }

        if(!empty($req_route)){
            $route = $req_route;
        }

        return (new self)->search($request, $route, $queryType);
    }
}
