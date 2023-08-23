<?php

use App\Http\Controllers\RepositoryControllers\ProductAttributes\AttributeController;
use Illuminate\Support\Facades\Route;


Route::controller(AttributeController::class)->group(function () {
    Route::prefix('repository/products')->group(function (){

        Route::get('/attributes/{id}', 'show')->middleware('permission:show attribute');
        Route::get('/attributes', 'index')->middleware('permission:index attribute');
        Route::post('/attributes', 'store')->middleware('permission:store attribute');
        Route::put('/attributes/{id}', 'update')->middleware('permission:update attribute');
        Route::delete('/attributes/{id}', 'destroy')->middleware('permission:destroy attribute');

    });
});
