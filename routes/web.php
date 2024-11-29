<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/home', fn() => Inertia::render('Home'))->name('home');
Route::prefix('/checkout')
    ->name('checkout.')
    ->group(function () {
        Route::get('/details', fn() => Inertia::render('Checkout/Details'))->name('details');
        Route::get('/form', fn() => Inertia::render('Checkout/Form'))->name('form');
    });


Route::prefix('/products')
    ->name('products.')
    ->group(function () {
        Route::get('/{product:id}', fn() => Inertia::render('Product/Show'))->name('show');
    });

Route::prefix('/orders')
    ->name('orders.')
    ->group(function () {
        Route::get('/track/{order:id}', fn() => Inertia::render('Order/Track'))->name('track');
    });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])
    ->prefix('management')
    ->name('management.')
    ->group(function () {
        Route::prefix('products')
            ->name('products.')
            ->group(function () {
                Route::get('/', fn() => Inertia::render('Management/Product/List'))->name('list');
                Route::get('/create', fn() => Inertia::render('Management/Product/Create'))->name('create');
                Route::get('/edit/{id}', fn() => Inertia::render('Management/Product/Edit'))->name('edit');
                Route::get('/{id}', fn() => Inertia::render('Management/Product/Show'))->name('show');
            });

        Route::prefix('orders')
            ->name('orders.')
            ->group(function () {
                Route::get('/', fn() => Inertia::render('Management/Order/List'))->name('list');
                Route::get('/queue', fn() => Inertia::render('Management/Order/Queue'))->name('queue');
            });
    });
