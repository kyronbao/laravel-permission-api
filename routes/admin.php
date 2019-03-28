<?php


use Admin\Http\Controllers;


Route::post('login', Controllers\StuffController::class.'@login');
