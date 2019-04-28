<?php


use Admin\Controllers\PermissionController;
use Admin\Controllers\StuffController;


Route::prefix('auth')->group(function () {

    Route::get('menu', PermissionController::class . '@getMenu');
    Route::get('stuff', StuffController::class . '@getStuff');
    Route::post('logout', StuffController::class . '@logout');

    Route::middleware('auth.admin.route')->group(function () {
        Route::post('post-roles', PermissionController::class . '@postRoles');
        Route::get('get-roles', PermissionController::class . '@getRoles');
        Route::post('post-permissions-via-role', PermissionController::class . '@postPermissionsViaRole');
        Route::get('get-permissions-via-role', PermissionController::class . '@getPermissionsViaRole');
        Route::post('post-menus-via-role', PermissionController::class . '@postMenusViaRole');
        Route::get('get-menus-via-role', PermissionController::class . '@getMenusViaRole');

        Route::post('post-permissions', PermissionController::class . '@postPermissions');
        Route::get('get-permissions', PermissionController::class . '@getPermissions');

        Route::post('post-menus', PermissionController::class . '@postMenus');
        Route::get('get-menus', PermissionController::class . '@getMenus');

        Route::get('get-stuffs', PermissionController::class . '@getStuffs');
        Route::post('delete-stuff', PermissionController::class . '@deleteStuff');
        Route::post('post-roles-via-user', PermissionController::class . '@postRolesViaUser');
        Route::get('get-roles-via-user', PermissionController::class . '@getRolesViaUser');

    });
});

