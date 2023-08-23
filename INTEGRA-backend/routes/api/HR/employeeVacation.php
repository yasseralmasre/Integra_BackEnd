<?php

use App\Http\Controllers\HRControllers\EmployeeVacationController;
use Illuminate\Support\Facades\Route;

Route::controller(EmployeeVacationController::class)->group(function () {
    Route::prefix('hr')->group(function (){

        Route::get('/employeeVacations/{id}', 'show')->middleware('permission:show employeeVacation');
        Route::get('/employeeVacations', 'index')->middleware('permission:index employeeVacation');
        Route::post('/employeeVacations', 'store')->middleware('permission:store employeeVacation');
        Route::put('/employeeVacations/{id}', 'update')->middleware('permission:update employeeVacation');
        Route::delete('/employeeVacations/{id}', 'destroy')->middleware('permission:destroy employeeVacation');

    });
});


