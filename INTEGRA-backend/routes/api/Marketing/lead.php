<?php

use App\Http\Controllers\MarketingControllers\LeadController;
use Illuminate\Support\Facades\Route;

Route::controller(LeadController::class)->group(function () {
    Route::prefix('marketing')->group(function (){
        
        Route::get('/leads/showLeadCustomers/{id}', 'showLeadCustomers')->middleware('permission:show LeadCustomers');
        Route::get('/leads/showLeadCampaigns/{id}', 'showLeadCampaigns')->middleware('permission:show showLeadCampaigns');

        Route::get('/leads/{id}', 'show')->middleware('permission:show lead');
        Route::get('/leads', 'index')->middleware('permission:index lead');

        Route::post('/leads/attachLeadToCustomer/{id}', 'attachLeadToCustomer')->middleware('permission:attach LeadToCustomer');
        Route::post('/leads/detachLeadToCustomer/{id}', 'detachLeadToCustomer')->middleware('permission:detach LeadToCustomer');

        Route::post('/leads', 'store')->middleware('permission:store lead');
        Route::put('/leads/{id}', 'update')->middleware('permission:update lead');
        Route::delete('/leads/{id}', 'destroy')->middleware('permission:destroy lead');

    });
});
