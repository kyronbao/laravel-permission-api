<?php


use Admin\Http\Controllers\PermissionController;


Route::post('post-roles', PermissionController::class . '@postRoles');
Route::get('get-roles', PermissionController::class . '@getRoles');
Route::post('post-permissions-via-role', PermissionController::class . '@postPermissionsViaRole');
Route::get('get-permissions-via-role', PermissionController::class . '@getPermissionsViaRole');

Route::post('post-permissions', PermissionController::class . '@postPermissions');
Route::get('get-permissions', PermissionController::class . '@getPermissions');

Route::post('post-roles-via-user', PermissionController::class . '@postRolesViaUser');
Route::get('get-roles-via-user', PermissionController::class . '@getRolesViaUser');
