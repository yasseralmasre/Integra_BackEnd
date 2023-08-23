<?php

use App\Http\Controllers\MarketingControllers\TvController;
use Illuminate\Support\Facades\Route;

Route::controller(TvController::class)->group(function () {
    Route::prefix('marketing')->group(function (){

        Route::get('/tvs/{id}', 'show')->middleware('permission:show Tv');
        Route::get('/tvs', 'index')->middleware('permission:index Tv');
        Route::post('/tvs', 'store')->middleware('permission:store Tv');
        Route::put('tvs/{id}', 'update')->middleware('permission:update Tv');
        Route::delete('/tvs/{id}', 'destroy')->middleware('permission:destroy Tv');

    });
});
