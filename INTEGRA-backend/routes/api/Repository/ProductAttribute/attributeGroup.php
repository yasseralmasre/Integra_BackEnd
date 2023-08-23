<?php

use App\Http\Controllers\RepositoryControllers\ProductAttributes\AttributeGroupController;
use Illuminate\Support\Facades\Route;


Route::controller(AttributeGroupController::class)->group(function () {
    Route::prefix('repository/products')->group(function (){

        Route::get('attributeGroups/attributesOfGroup/{id}', 'getAttributesByGroup')->middleware('permission:get AttributesByGroup');
        Route::get('/attributeGroups/{id}', 'show')->middleware('permission:show attributeGroup');
        Route::get('/attributeGroups', 'index')->middleware('permission:index attributeGroup');
        Route::post('/attributeGroups', 'store')->middleware('permission:store attributeGroup');
        Route::put('/attributeGroups/{id}', 'update')->middleware('permission:update attributeGroup');
        Route::delete('/attributeGroups/{id}', 'destroy')->middleware('permission:destroy attributeGroup');

    });
});
