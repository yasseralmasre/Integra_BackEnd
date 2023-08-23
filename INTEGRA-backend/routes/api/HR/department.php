<?php

use App\Http\Controllers\HRControllers\DepartmentController;
use Illuminate\Support\Facades\Route;

Route::controller(DepartmentController::class)->group(function () {
    Route::prefix('hr')->group(function (){
        
        Route::get('/departmentEmployees/{id}', 'showdepartmentEmployees')->middleware('permission:show departmentEmployees');
        Route::get('/departments/{id}', 'show')->middleware('permission:show department');
        Route::get('/departments', 'index')->middleware('permission:index department');
        Route::post('/departments', 'store')->middleware('permission:store department');
        Route::put('/departments/{id}', 'update')->middleware('permission:update department');
        Route::delete('/departments/{id}', 'destroy')->middleware('permission:destroy department');


    });
});

