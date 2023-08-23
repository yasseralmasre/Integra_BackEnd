<?php

use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Route;

Route::controller(PDFController::class)->group(function () {
        Route::post('/pdfs/storeCampaign/{id}', 'storeCampaign')->middleware('permission:store Campaign pdf');
        Route::post('/pdfs/storeEmployeeVecation/{id}', 'storeEmployeeVacation')->middleware('permission: store EmployeeVacation pdf');
        Route::get('/pdfs/storeExport/{id}', 'storeExport')->middleware('permission:store Export pdf');
        Route::post('/pdfs/storeImport/{id}', 'storeImport')->middleware('permission:store Import pdf');

        Route::get('/pdfs/{id}', 'show')->middleware('permission:show pdf');
        Route::get('/pdfs', 'index')->middleware('permission:index pdf');
        Route::delete('/pdfs/{id}', 'destroy')->middleware('permission:destroy pdf')->middleware('permission:destroy pdf');

});
