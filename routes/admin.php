<?php


use Admin\Http\Controllers;


Route::get('/stuff', Controllers\StuffController::class . '@getStuff');

Route::post('post-roles', Controllers\PermissionController::class . '@postRoles');
Route::get('get-roles', Controllers\PermissionController::class . '@getRoles');

Route::post('post-menus', Controllers\PermissionController::class . '@postMenus');
Route::get('get-menus', Controllers\PermissionController::class . '@getMenus');
