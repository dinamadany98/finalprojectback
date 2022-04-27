<?php

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderItemController;
use App\Http\Controllers\Frontend\RatingController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\ForgetPasswordController;


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
Route::get('/view-category/{slug}',[FrontendController::class,'viewcategory'])
->middleware('auth:sanctum');

Route::get('/category/{cat_slug}/{prod_slug}',[FrontendController::class,'viewproduct'])
->middleware('auth:sanctum');

Route::post('/add-rating',[RatingController::class,'store'])
->middleware('auth:sanctum');

Route::post('/add-review',[ReviewController::class,'store'])
->middleware('auth:sanctum');
Route::apiResource('/reviews',ReviewController::class);

Route::get('/add-review/{slug}/userreview',[ReviewController::class,'add'])
->middleware('auth:sanctum');

Route::get('/edit-review/{slug}/userreview',[ReviewController::class,'edit'])
->middleware('auth:sanctum');

Route::put('/update-review',[ReviewController::class,'update'])
->middleware('auth:sanctum');

Route::get('/checkreview/{prodid}',[ReviewController::class,'checkreview'])
->middleware('auth:sanctum');
//--------------------------------------------------------------------
Route::post("/register",[AuthController::class,'register']);

Route::post("/login", [AuthController::class,'login']);

Route::delete("/logout", [AuthController::class,'logout'])
->middleware('auth:sanctum');

Route::resource('/categories', CategoryController::class)->middleware('auth:sanctum');

Route::get('/getProductsbyCategory/{category_id}', [FrontendController::class, 'getProductsbyCategory']);
Route::get('/getallcategories', [FrontendController::class, 'getallcategory']);
Route::get('/getallproduct', [FrontendController::class, 'getallproduct']);



Route::get('productsdetails/{id}', [ProductController::class, 'productdetails']);
Route::resource('products',ProductController::class)->middleware('auth:sanctum');
Route::apiResource('/users',UserController::class)->middleware('auth:sanctum');
//-------------------------Admin View Users ----------------------------
Route::get('usersAdmin',[DashboardController::class,'users'])->
middleware('auth:sanctum');
Route::get('view-user/{id}',[DashboardController::class,'show'])->
middleware('auth:sanctum');
Route::put('update-user/{id}',[DashboardController::class,'update'])->middleware('auth:sanctum');
//----------------------------------------------------------------------
//-----------------------Admin View Orders------------------------------
Route::resource('orders',OrderController::class)->middleware('auth:sanctum');
Route::get('order-history',[OrderController::class,'orderhistory'])->middleware('auth:sanctum');
//----------------------------------------------------------------------

Route::get('/getuserorder',[OrderItemController::class,"getuserorder"])->middleware('auth:sanctum');
Route::get('/getorderforspasificuser',[OrderItemController::class,"getorderforspasificuser"])->middleware('auth:sanctum');
Route::apiResource('/OrderItem',OrderItemController::class)->middleware('auth:sanctum');

Route::put('/updatestatus/{orderid}',[OrderItemController::class,"updatestatus"]);




Route::get('getproducts/{id}',[ProductController::class,'getProductsbyCategory'])
->middleware('auth:sanctum');


Route::resource('cart',CartController::class)->middleware('auth:sanctum');


Route::post('increment/{prodid}',[CartController::class,'increment']);
Route::post('cart/{prodid}',[CartController::class,'decrement']);
Route::delete('cartuser',[CartController::class,'deletecart'])
->middleware('auth:sanctum');

Route::resource('wishlist',WishlistController::class)
->middleware('auth:sanctum');

Route::delete('wishlistuser',[WishlistController::class,'deletewishlist'])
->middleware('auth:sanctum');

Route::get('search/{name}',[ProductController::class,'searchproduct']);
/////dashboard admin*******

Route::get('/numberusers',[DashboardController::class,'users_number'])
->middleware('auth:sanctum');

Route::get('/numbercustomers',[DashboardController::class,'customers_number'])
->middleware('auth:sanctum');

Route::get('/todayorders',[DashboardController::class,'orders'])
->middleware('auth:sanctum');
Route::get('/sales',[DashboardController::class,'sales'])
->middleware('auth:sanctum');

Route::get('/rateproduct',[DashboardController::class,'rating'])
->middleware('auth:sanctum');

////end dashboard/////////

Route::post('/resetpassword',[ForgetPasswordController::class,'resetPassword']);
Route::post('/updatepassword',[UserController::class,'updatepassword']);
Route::get('/showuser/{id}',[UserController::class,'showuser'])->middleware('auth:sanctum');



Route::get('/mail',[OrderItemController::class,'sendmail']);


