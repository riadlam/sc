<?php

namespace Plugins\PageBuilder\Helpers\Traits;

trait RenderViews
{
    public static function renderView($filename, $data = [], $moduleName = '')
    {
        $view_path = !empty($moduleName) ? strtolower($moduleName).'::addon-view.' : 'pagebuilder::';

        if(!view()->exists($view_path . $filename)){
            if(str_contains($filename,'theme_one') || str_contains($filename,'theme_two')){
                $filename = str_replace(['theme_one','theme_two'],"hexfashion",$filename);
            }
        }
        
        return view($view_path . $filename, compact('data'))->render();
    }
}
