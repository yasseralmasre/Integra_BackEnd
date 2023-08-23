<?php

use App\Http\Controllers\RepositoryControllers\ExportController;
use Illuminate\Support\Facades\Route;

Route::controller(ExportController::class)->group(function () {
    Route::prefix('/repository')->group(function (){

        Route::get('/exports/{id}', 'show')->middleware('permission:show export');
        Route::get('/exports', 'index')->middleware('permission:index export');
        Route::post('/exports', 'store')->middleware('permission:store export');
        Route::put('/exports/{id}', 'update')->middleware('permission:update export');
        Route::delete('/exports/{id}', 'delete')->middleware('permission:destroy export');

    });
});
