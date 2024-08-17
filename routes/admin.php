<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->as('admin.')
    ->group(function () {

        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('index');

        Route::resource('categories', \App\Http\Controllers\Admin\AdminCategoryController::class);

        Route::resource('products', \App\Http\Controllers\Admin\AdminProductController::class);

        Route::resource('attributes', \App\Http\Controllers\Admin\AdminAttributeController::class);

        Route::resource('tags', \App\Http\Controllers\Admin\AdminTagController::class);
//        Route::resource('order', OrderController::class);

    });

