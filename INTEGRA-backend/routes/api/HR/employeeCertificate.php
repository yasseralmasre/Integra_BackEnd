<?php

use App\Http\Controllers\HRControllers\EmployeeCertificateController;
use Illuminate\Support\Facades\Route;


Route::controller(EmployeeCertificateController::class)->group(function () {
    Route::prefix('hr')->group(function (){

        Route::get('/employeeCertificates/{id}', 'show')->middleware('permission:show employeeCertificate');
        Route::get('/employeeCertificates', 'index')->middleware('permission:index employeeCertificate');
        Route::post('/employeeCertificates', 'store')->middleware('permission:store employeeCertificate');
        Route::put('/employeeCertificates/{id}', 'update')->middleware('permission:update employeeCertificate');
        Route::delete('/employeeCertificates/{id}', 'destroy')->middleware('permission:destroy employeeCertificate');

    });
});
