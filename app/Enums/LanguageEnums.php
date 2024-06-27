<?php

namespace App\Enums;

class LanguageEnums
{
    public static function getdirection(int $const)
    {
        if ($const === 0){
            return 'ltr';
        }elseif ($const === 1){
            return 'rtl';
        }
    }
}
