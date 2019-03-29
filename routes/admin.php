<?php


use Admin\Http\Controllers;


Route::get('/stuff', Controllers\StuffController::class . '@getStuff');

