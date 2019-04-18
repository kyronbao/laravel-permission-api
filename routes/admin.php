<?php


use Admin\Http\Controllers;


Route::post('post-roles', Controllers\PermissionController::class . '@postRoles');
Route::get('get-roles', Controllers\PermissionController::class . '@getRoles');
Route::post('post-permissions-via-role', Controllers\PermissionController::class . '@postPermissionsViaRole');
Route::get('get-permissions-via-role', Controllers\PermissionController::class . '@getPermissionsViaRole');

Route::post('post-permissions', Controllers\PermissionController::class . '@postPermissions');
Route::get('get-permissions', Controllers\PermissionController::class . '@getPermissions');

Route::post('post-roles-via-user', Controllers\PermissionController::class . '@postRolesViaUser');
Route::get('get-roles-via-user', Controllers\PermissionController::class . '@getRolesViaUser');
