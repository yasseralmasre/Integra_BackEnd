<?php

use App\Http\Controllers\HRControllers\EmployeePerformanceController;
use Illuminate\Support\Facades\Route;

Route::controller(EmployeePerformanceController::class)->group(function () {
    Route::prefix('hr')->group(function (){
        Route::get('/employeePerformances/{id}', 'show')->middleware('permission:show employeePerformance');
        Route::get('/employeePerformances', 'index')->middleware('permission:index employeePerformance');
        Route::post('/employeePerformances', 'store')->middleware('permission:sstore employeePerformance');
        Route::put('/employeePerformances/{id}', 'update')->middleware('permission:update employeePerformance');
        Route::delete('/employeePerformances/{id}', 'destroy')->middleware('permission:destroy employeePerformance');

    });
});


