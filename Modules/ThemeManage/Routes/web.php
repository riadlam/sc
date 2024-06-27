<?php

use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Modules\ThemeManage\Http\Controllers\ThemeManageController;
use App\Http\Middleware\Tenant\InitializeTenancyByDomainCustomisedMiddleware;

Route::middleware([
    'web',
//    InitializeTenancyByDomain::class,
    InitializeTenancyByDomainCustomisedMiddleware::class,
    PreventAccessFromCentralDomains::class,
    'auth:admin',
    'tenant_admin_glvar',
    'package_expire',
    'set_lang',
    'tenantAdminPanelMailVerify'
])->prefix('admin-home')->name('tenant.')->group(function () {
    /*==============================================
                    THEME MANAGE MODULE
    ==============================================*/

    Route::prefix('themes')->name('admin.theme.')->controller(ThemeManageController::class)->group(function (){
        Route::get('/', 'index')->name('all');
        Route::post('/update/{slug}', 'update')->name('update');
    });
});
