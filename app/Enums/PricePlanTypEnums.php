<?php

namespace App\Enums;

class PricePlanTypEnums
{
    const MONTHLY = 0;
    const YEARLY = 1;
    const LIFETIME = 2;

    public static function getText(int $const)
    {
        if ($const == self::MONTHLY){
            return __('Monthly');
        }elseif ($const == self::YEARLY){
            return __('Yearly');
        }elseif ($const == self::LIFETIME){
            return __('Lifetime');
        }
    }

    public static function getFeatureList()
    {
        return [
            'products' => __('products'),
            'pages' => __('pages'),
            'blog' => __('blog'),
            'storage' => __('storage'),
            'inventory' => __('inventory'),
            'campaign' => __('campaign'),
            'coupon' => __('coupon'),
            'digital_product' => __('digital product'),
            'custom_domain' => __('custom domain'),
            'newsletter' => __('newsletter'),
            'testimonial' => __('testimonial'),
            'app_api' => __('app api')
        ];
    }
}
