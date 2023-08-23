<?php

use App\Http\Controllers\RepositoryControllers\ImportController;
use Illuminate\Support\Facades\Route;


Route::controller(ImportController::class)->group(function () {
    Route::prefix('repository')->group(function (){

        Route::get('/imports/{id}', 'show')->middleware('permission:show import');
        Route::get('/imports', 'index')->middleware('permission:index import');
        Route::post('/imports', 'store')->middleware('permission:store import');
        Route::put('/imports/{id}', 'update')->middleware('permission:update import');
        Route::delete('/imports/{id}', 'delete')->middleware('permission:destroy import');


    });
});
