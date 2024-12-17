<?php

use Illuminate\Support\Facades\Route;

Route::domain('dashboard.b2b.test')->as('dashboard.')->group(function () {
    Route::get('/login', function () {
        return 'login';
    })->name('login');

    Route::middleware('auth:web')->group(function () {
        Route::get('/', function () {
            return 'dashboard anasayfa';
        });
    });
});
