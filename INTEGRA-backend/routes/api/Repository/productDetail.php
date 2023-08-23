    <?php

use App\Http\Controllers\RepositoryControllers\ProductDetailController;
use Illuminate\Support\Facades\Route;


Route::controller(ProductDetailController::class)->group(function () {
    Route::prefix('repository')->group(function (){

        Route::get('/productDetails/{id}', 'show')->middleware('permission:show productDetails');
        Route::get('/productDetails', 'index')->middleware('permission:index productDetails');
        Route::post('/productDetails', 'store')->middleware('permission:store productDetails');
        Route::put('/productDetails/{id}', 'update')->middleware('permission:update productDetails');
        Route::delete('/productDetails/{id}', 'destroy')->middleware('permission:destroy productDetails');

    });
});
