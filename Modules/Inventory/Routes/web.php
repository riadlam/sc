<?php

use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Modules\Inventory\Http\Controllers\InventoryController;
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
    'tenantAdminPanelMailVerify',
//    'tenant_feature_permission',
    \App\Http\Middleware\Tenant\TenantCheckPermission::class
])->name('tenant.')->group(function () {
    /*-----------------------------------
        INVENTORY ROUTES
    ------------------------------------*/
    Route::prefix('admin-home/product-inventory')->name('admin.product.inventory.')->group(function () {
        Route::controller(InventoryController::class)->group(function () {
            Route::get('/', 'index')->name('all');
            Route::get('edit/{item}', 'edit')->name('edit');
            Route::post('update', 'update')->name('update'); // [===== ??? =====]
            Route::post('delete/{item}', 'destroy')->name('delete');
            Route::post('bulk-action', 'bulk_action')->name('bulk.action');
            Route::post('attribute-delete', 'removeProductInventory')->name('attribute.delete');
            Route::post('details-attribute-delete', 'removeInventoryDetailsAttribute')->name('details.attribute.delete');

            Route::get('settings', 'settings')->name('settings');
            Route::post('settings', 'settings_update');
        });
    });
});
