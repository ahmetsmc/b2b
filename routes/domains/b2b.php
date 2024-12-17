<?php

use Illuminate\Support\Facades\Route;

Route::domain('b2b.test')->as('front.')->group(function () {
    Route::get('/', function () {
        return 'test';
    });
});
