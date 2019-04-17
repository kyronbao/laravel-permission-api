<?php


use Admin\Http\Controllers;


Route::post('post-roles', Controllers\PermissionController::class . '@postRoles');
Route::get('get-roles', Controllers\PermissionController::class . '@getRoles');

Route::post('post-routes', Controllers\PermissionController::class . '@postRoutes');


Route::post('post-roles-via-user', Controllers\PermissionController::class . '@postRolesViaUser');
Route::get('get-roles-via-user', Controllers\PermissionController::class . '@getRolesViaUser');
Route::post('post-routes-via-role', Controllers\PermissionController::class . '@postRoutesViaRole');
Route::get('get-permissions-via-role', Controllers\PermissionController::class . '@getPermissionsViaRole');