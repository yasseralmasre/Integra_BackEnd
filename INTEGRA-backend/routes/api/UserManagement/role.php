<?php

use App\Http\Controllers\UserManagementController\RoleController;
use Illuminate\Support\Facades\Route;

Route::controller(RoleController::class)->group(function () {
Route::prefix('userManagement')->group(function(){
    Route::get('/roles/roleUsers/{id}','showRoleUsers')->middleware('permission:show RoleUsers');
    Route::get('/roles/rolePermissions/{id}','showRolePermissions')->middleware('permission:show RolePermissions');
    Route::get('/roles/{name}', 'show')->middleware('permission:show role');
    Route::get('/roles','index')->middleware('permission:index role');
    Route::post('/roles' ,'store')->middleware('permission:store role');
    Route::delete('/roles/{name}',  'destroy')->middleware('permission:destroy role');
    Route::put('/roles/{id}', 'update')->middleware('permission:update role');

    Route::post('/roles/attach/{id}',  'attach')->middleware('permission:attach RolePermissions');
    Route::post('/roles/detach/{id}', 'detach')->middleware('permission:detach RolePermissions');

    Route::post('/roles/assignRole/{id}', 'assignRole')->middleware('permission:assign Role');
    Route::post('/roles/unassignRole/{id}', 'unassignRole')->middleware('permission:unassign Role');

});
});
