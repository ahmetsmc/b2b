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


Route::get('/test', [\App\Http\Controllers\TestController::class, 'test']);
Route::get('/test2', [\App\Http\Controllers\TestController::class, 'test2']);
Route::post('/test2', [\App\Http\Controllers\TestController::class, 'test3']);
