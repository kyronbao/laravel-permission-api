<?php


use Admin\Http\Controllers;


Route::post('login', Controllers\StuffController::class.'@login');
Route::get('stuff', Controllers\StuffController::class . '@getStuff');
