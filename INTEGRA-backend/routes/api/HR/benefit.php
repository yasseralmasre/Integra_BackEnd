<?php

use App\Http\Controllers\HRControllers\BenefitController;
use Illuminate\Support\Facades\Route;


Route::controller(BenefitController::class)->group(function () {
    Route::prefix('hr')->group(function (){
        
        Route::get('/benefitEmployees/{id}', 'showbenefitEmployees')->middleware('permission:show benefitEmployees');
        Route::get('/benefits/{id}', 'show')->middleware('permission:show benefit');
        Route::get('/benefits', 'index')->middleware('permission:index benefit');
        Route::post('/benefits', 'store')->middleware('permission:store benefit');
        Route::put('/benefits/{id}', 'update')->middleware('permission:update benefit');
        Route::delete('/benefits/{id}', 'destroy')->middleware('permission:destroy benefit');


    });
});

