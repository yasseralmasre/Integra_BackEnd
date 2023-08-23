<?php

use App\Http\Controllers\UserManagementController\PermissionController;
use Illuminate\Support\Facades\Route;


Route::controller(PermissionController::class)->group(function () {
Route::prefix('userManagement')->group(function(){
    Route::get('/permissions/{id}', 'showPermissionRoles')->middleware('permission:show PermissionRoles');
    Route::get('/permissions', 'index')->middleware('permission:index Permission');;
    
});
});
