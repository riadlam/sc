<?php

namespace App\Providers;

use App\Helpers\LanguageHelper;
use App\Helpers\ModuleMetaData;
use App\Helpers\SidebarMenuHelper;
use App\Helpers\ThemeMetaData;
use App\Models\Themes;
use App\Observers\WalletBalanceObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Modules\Blog\Entities\BlogCategory;
use Modules\Wallet\Entities\Wallet;
use function Psy\bin;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app()->singleton('LandlordAdminMenu',function (){
           return  new SidebarMenuHelper();
        });
        app()->singleton('GlobalLanguage',function (){
           return  new LanguageHelper();
        });

        $this->app->singleton('ThemeDataFacade', function (){
            return new ThemeMetaData();
        });
        $this->app->singleton('ModuleDataFacade', function (){
            return new ModuleMetaData();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        if (get_static_option('site_force_ssl_redirection') === 'on'){
            URL::forceScheme('https');
        }
    }
}
