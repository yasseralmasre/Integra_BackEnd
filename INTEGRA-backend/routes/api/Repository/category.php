<?php

use App\Http\Controllers\RepositoryControllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::controller(CategoryController::class)->group(function () {
    Route::prefix('repository')->group(function (){

        Route::get('/categories/products/{id}', 'getProductsByCategory')->middleware('permission:get ProductsByCategory');
        Route::get('/categories/{id}', 'show')->middleware('permission:show category');
        Route::get('/categories', 'index')->middleware('permission:index category');
        Route::post('/categories', 'store')->middleware('permission:store category');
        Route::put('/categories/{id}', 'update')->middleware('permission:update category');
        Route::delete('/categories/{id}', 'destroy')->middleware('permission:destroy category');

    });
});

