<?php

use App\Http\Controllers\MarketingControllers\EventController;
use Illuminate\Support\Facades\Route;

Route::controller(EventController::class)->group(function () {
    Route::prefix('marketing')->group(function (){
        
        Route::get('/events/{id}', 'show')->middleware('permission:show event');
        Route::get('/events', 'index')->middleware('permission:index event');
        Route::post('/events', 'store')->middleware('permission:store event');
        Route::put('/events/{id}', 'update')->middleware('permission:update event');
        Route::delete('/events/{id}', 'destroy')->middleware('permission:destroy event');

    });
});
