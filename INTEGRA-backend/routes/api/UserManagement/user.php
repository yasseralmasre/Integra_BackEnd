<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->group(function () {
Route::prefix('userManagement')->group(function(){
    Route::get('/users/userRoles/{id}', 'showUserRoles')->middleware('permission:show UserRoles');;
    Route::get('/users/{id}','show')->middleware('permission:show user');;
    Route::get('/users', 'index')->middleware('permission:index user');;
    Route::post('/users', 'store')->middleware('permission:store user');;
    Route::delete('/users/{id}', 'destroy')->middleware('permission:destroy user');;
    Route::put('/users/{id}',  'update')->middleware('permission:update user');;
});
    Route::get('/getMe', 'getMe');
});
