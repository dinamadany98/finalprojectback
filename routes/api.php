<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
<<<<<<< HEAD
use App\Http\Controllers\Admin\OrderItemController;
use App\Models\Product;
=======
use App\Http\Controllers\Frontend\FrontendController;
>>>>>>> master

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
//-----------------------User Home Page-------------------------------
Route::get('/',[FrontendController::class,'index']);
Route::get('/view-category/{slug}',[FrontendController::class,'viewcategory']);
Route::get('/category/{cat_slug}/{prod_slug}',[FrontendController::class,'viewproduct']);
//--------------------------------------------------------------------
Route::post("/register",[ AuthController::class, 'register']);
Route::post("/login", [AuthController::class,'login']);

Route::resource('/categories', CategoryController::class);

<<<<<<< HEAD
Route::apiResource('/OrderItem',OrderItemController::class);
=======
Route::resource('products',ProductController::class);
Route::get('getproducts/{id}',[ProductController::class,'getProductsbyCategory']);
>>>>>>> master
