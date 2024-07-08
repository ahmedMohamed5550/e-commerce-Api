<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\brandsController;
use App\Http\Controllers\categoriesController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\locationController;
use App\Http\Controllers\ordersController;
use App\Http\Controllers\productsController;
use App\Models\employee;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// // authController
// Route::controller(AuthController::class)->middleware('api')->prefix('auth')->group(function ($router) {
//     Route::post('login', 'login');
//     Route::post('register', 'register');
//     Route::post('logout', 'logout');
//     Route::post('refresh', 'refresh');
// });


// authController routes

// Route::group([
//     'middleware' => 'api',
//     'prefix'=>'auth'
// ], function ($router) {
//     Route::post('/register', [AuthController::class,'register']);
//     Route::post('/login', [AuthController::class,'login']);
//     Route::post('/logout', [AuthController::class,'logout']);
//     Route::post('/refresh', [AuthController::class,'refresh']);
// });


Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);



Route::middleware(['auth:api'])->group(function(){

    Route::middleware('auth-admin')->group(function(){
                // brands crud
                Route::group(['prefix'=>'brands'],function(){
                    Route::controller(brandsController::class)->group(function(){
                        Route::get('/', 'index');
                        Route::get('show/{id}', 'show');
                        Route::delete('destroy/{id}', 'destroy');
                        Route::get('search/{name}', 'search');
                        Route::post('store', 'store');
                        Route::post('update/{id}', 'update');
                    });
                });

                // categories crud
                Route::group(['prefix'=>'category'],function(){
                    Route::controller(categoriesController::class)->group(function(){
                        Route::get('/', 'index');
                        Route::get('show/{id}', 'show');
                        Route::delete('destroy/{id}', 'destroy');
                        Route::post('store', 'store');
                        Route::post('update/{id}', 'update');
                    });
                });

                // location crud
                Route::group(['prefix'=>'location'],function($router){
                    Route::controller(locationController::class)->group(function(){
                        Route::delete('destroy/{id}', 'destroy');
                        Route::post('store', 'store');
                        Route::post('update/{id}', 'update');
                    });
                });

                // products crud
                Route::group(['prefix'=>'products'],function($router){
                    Route::controller(productsController::class)->group(function(){
                        Route::get('/', 'index');
                        Route::get('show/{id}', 'show');
                        Route::delete('destroy/{id}', 'destroy');
                        Route::get('search/{name}', 'search');
                        Route::post('store', 'store');
                        Route::post('update/{id}', 'update');
                    });
                });

                // order crud
                Route::group(['prefix'=>'orders'],function($router){
                    Route::controller(ordersController::class)->group(function(){
                        Route::get('/', 'index');
                        Route::get('show/{id}', 'show');
                        Route::get('get_order_items/{id}', 'get_order_items');
                        Route::get('get_user_orders/{id}', 'get_user_orders');
                        Route::post('store', 'store');
                        Route::post('changeOrderStatus/{id}', 'changeOrderStatus');
                    });
                });
    });


Route::post('/logout', [AuthController::class,'logout']);

});


Route::group(['prefix'=>'employee'],function(){
    Route::controller(EmployeeController::class)->group(function(){
    Route::post('store', 'store');
    });
});

