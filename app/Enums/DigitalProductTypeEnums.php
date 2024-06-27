<?php

namespace App\Enums;

class DigitalProductTypeEnums
{
    public static function getText(string $const)
    {
        if ($const === 'd_image'){
            return __('Image');
        }elseif ($const === 'd_video'){
            return __('Video');
        }elseif ($const === 'd_audio'){
            return __('Audio');
        }elseif ($const === 'd_file'){
            return __('File');
        }
    }
}
