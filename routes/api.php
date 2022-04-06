<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\User\CartController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/register",[ AuthController::class, 'register']);
Route::post("/login", [AuthController::class,'login']);

Route::resource('/categories', CategoryController::class);

Route::resource('products',ProductController::class);
Route::get('getproducts/{id}',[ProductController::class,'getProductsbyCategory']);


Route::resource('cart',CartController::class);
