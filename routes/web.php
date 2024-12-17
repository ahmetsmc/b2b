<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});


//Route::domain('b2b.test')->as('front.')->group(function () {
//    Route::get('/', function () {
//        return 'test';
//    });
//});
//
//
//Route::domain('dashboard.b2b.test')->as('dashboard.')->group(function () {
//
//    Route::get('/login', function () {
//        return 'login';
//    })->name('login');
//
//    Route::middleware('auth:web')->group(function () {
//        Route::get('/', function () {
//            return 'dashboard anasayfa';
//        });
//    });
//});

Route::get('/test', [\App\Http\Controllers\TestController::class, 'test']);
Route::get('/test2', [\App\Http\Controllers\TestController::class, 'test2']);
Route::post('/test2', [\App\Http\Controllers\TestController::class, 'test3']);
