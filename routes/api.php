<?php

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\Admin\OrderItemController;
use App\Http\Controllers\Frontend\RatingController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Frontend\FrontendController;

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
Route::post('add-rating',[RatingController::class,'store']);
Route::post('/add-review',[ReviewController::class,'store']);
Route::get('/add-review/{slug}/userreview',[ReviewController::class,'add']);
Route::get('/edit-review/{slug}/userreview',[ReviewController::class,'edit']);
Route::put('/update-review',[ReviewController::class,'update']);
//--------------------------------------------------------------------
Route::post("/register",[AuthController::class,'register']);

Route::post("/login", [AuthController::class,'login']);

Route::resource('/categories', CategoryController::class);

Route::apiResource('/OrderItem',OrderItemController::class);

Route::resource('products',ProductController::class);

Route::get('getproducts/{id}',[ProductController::class,'getProductsbyCategory']);


Route::resource('cart',CartController::class);

Route::delete('cartuser',[CartController::class,'deletecart']);

Route::resource('wishlist',WishlistController::class);

Route::delete('wishlistuser',[WishlistController::class,'deletewishlist']);
