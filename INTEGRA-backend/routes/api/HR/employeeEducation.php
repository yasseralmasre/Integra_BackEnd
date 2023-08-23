<?php

use App\Http\Controllers\HRControllers\EmployeeEducationController;
use Illuminate\Support\Facades\Route;

Route::controller(EmployeeEducationController::class)->group(function () {
    Route::prefix('hr')->group(function (){

        Route::get('/employeeEducations/{id}', 'show')->middleware('permission:show employeeEducation');
        Route::get('/employeeEducations', 'index')->middleware('permission:index employeeEducation');
        Route::post('/employeeEducations', 'store')->middleware('permission:store employeeEducation');
        Route::put('/employeeEducations/{id}', 'update')->middleware('permission:update employeeEducation');
        Route::delete('/employeeEducations/{id}', 'destroy')->middleware('permission:destroy employeeEducation');
        
    });
});

