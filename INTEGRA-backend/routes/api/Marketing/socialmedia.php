<?php

use App\Http\Controllers\MarketingControllers\SocialMediaController;
use Illuminate\Support\Facades\Route;

Route::controller(SocialMediaController::class)->group(function () {
    Route::prefix('marketing')->group(function (){

        Route::get('/socialMedia/{id}', 'show')->middleware('permission:show socialmedia');
        Route::get('/socialMedia', 'index')->middleware('permission:index socialmedia');
        Route::post('/socialMedia', 'store')->middleware('permission:store socialmedia');
        Route::put('/socialMedia/{id}', 'update')->middleware('permission:update socialmedia');
        Route::delete('/socialMedia/{id}', 'destroy')->middleware('permission:destroy socialmedia');

    });
});
