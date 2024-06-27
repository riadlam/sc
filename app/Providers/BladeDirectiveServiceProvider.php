<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeDirectiveServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Blade::directive('isTenant',function (){
            return tenant();
        });

        Blade::directive('tenant', function () {
            return "<?php if(tenant()): ?>";
        });

        Blade::directive('else', function () {
            return "<?php else: ?>";
        });

        Blade::directive('endtenant', function () {
            return "<?php endif ?>";
        });
    }
}
