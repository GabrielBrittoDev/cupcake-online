<?php

use App\Http\Controllers\V1\Order\OrderController;
use App\Http\Controllers\V1\Product\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')
    ->group(function () {
        Route::prefix('products')
            ->name('products.')
            ->controller(ProductController::class)
            ->group(function () {
                Route::get('/', 'list')->name('list');
                Route::get('/{product:id}', 'show')->name('show');
            });

        Route::prefix('orders')
            ->name('orders.')
            ->controller(ProductController::class)
            ->group(function () {
                Route::post('/', 'store')->name('store');
                Route::patch('/{order:id}', 'update')->name('update');
            });
    });

Route::prefix('v1')
    ->group(function () {
        Route::prefix('products')
            ->name('products.')
            ->controller(ProductController::class)
            ->group(function () {
                Route::get('/', 'list')->name('list');
                Route::get('/{product:id}', 'show')->name('show');
            });
    });


Route::middleware([
    config('jetstream.auth_session'),
])
    ->prefix('v1')
    ->group(function () {
        Route::prefix('management')
            ->name('management.')
            ->group(function () {
                Route::prefix('products')
                    ->name('products.')
                    ->controller(ProductController::class)
                    ->group(function () {
                        Route::get('/', 'index')->name('index');
                        Route::post('/', 'store')->name('store');
                        Route::get('/{product:id}', 'show')->name('show');
                        Route::patch('/{product:id}', 'update')->name('update');
                        Route::delete('/{product:id}', 'destroy')->name('destroy');
                    });
            });

        Route::prefix('orders')
            ->name('orders.')
            ->controller(OrderController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::get('/queue', 'listQueue')->name('list-queue');
                Route::get('/{order}', 'show')->name('show');
                Route::patch('/{order}', 'update')->name('update');
                Route::delete('/{order}', 'destroy')->name('destroy');
            });
    });
