<?php

namespace App\Enums;

class ProductTypeEnum
{
    const PHYSICAL = 1;
    const DIGITAL = 2;


    public static function getText($const)
    {
        if ($const == self::PHYSICAL){
            return __('physical');
        }elseif ($const == self::DIGITAL){
            return __('digital');
        }
    }

    public static function getId($const)
    {
        if (strtolower($const) == self::getText(self::PHYSICAL)){
            return 1;
        }elseif (strtolower($const) == self::getText(self::DIGITAL)){
            return 2;
        }
    }
}
