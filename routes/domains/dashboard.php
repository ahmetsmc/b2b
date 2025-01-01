<?php

use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ProductsController;
use Illuminate\Support\Facades\Route;

Route::domain('dashboard.b2b.test')->as('dashboard.')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'attempt']);

    Route::post('editor/upload', function () {
        return ""; //TODO
    })->name('editor.upload');

    Route::middleware('auth:web')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');

        Route::prefix('products')->as('products.')->group(function () {
            Route::get('/', [ProductsController::class, 'index'])->name('index');
            Route::get('/create', [ProductsController::class, 'create'])->name('create');
            Route::post('/create', [ProductsController::class, 'store']);
            Route::get('/{id}/edit', [ProductsController::class, 'edit'])->name('edit');
            Route::post('/{id}/edit', [ProductsController::class, 'update']);
            Route::get('/{id}/delete', [ProductsController::class, 'delete'])->name('delete');
            Route::post('/{id}/update/status', [ProductsController::class, 'updateStatus'])->name('update.status');
            Route::post('/bulk-update', [ProductsController::class, 'bulkUpdate'])->name('bulk.update');
            Route::post('/bulk-delete', [ProductsController::class, 'bulkDelete'])->name('bulk.delete');

            Route::prefix('/{id}/gallery')->as('gallery.')->group(function () {
                Route::get('/', [ProductsController::class, 'gallery'])->name('index');
                Route::post('/upload', [ProductsController::class, 'uploadGallery'])->name('upload');
                Route::post('/update/cover', [ProductsController::class, 'setCoverGallery'])->name('update.cover');
                Route::post('/update/ranking', [ProductsController::class, 'updateGalleryRanking'])->name('update.ranking');
                Route::post('/delete', [ProductsController::class, 'deleteGallery'])->name('delete');
            });

            Route::prefix('/{productId}/variants')->as('variants.')->group(function () {
                Route::post('/{variantId}/delete', [ProductsController::class, 'delete_product_variant'])->name('delete');
            });

            Route::prefix('/categories')->as('categories.')->group(function () {
                Route::get('/', [ProductsController::class, 'product_categories'])->name('index');
            });
        });
    });
});
