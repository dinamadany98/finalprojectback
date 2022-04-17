<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Models\Rating;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiResponseTrait;

class RatingController extends Controller
{
    use ApiResponseTrait;

    public function store(Request $request)
    {
            // replace number 2 with Auth::id();
        $stars_rated = $request['stars_rated'];
        $prod_id = $request['product_id'];
        $product_check = Product::where('id',$prod_id)->first();

        if($product_check){
            $verified_purchase = Order::where('orders.user_id', Auth::id())->join('order_items','orders.id','order_items.order_id')
            ->where('order_items.product_id',$prod_id)->get();
            // dd($product_check);

            if($verified_purchase->count() > 0){
                $existing_rating = Rating::where('user_id', Auth::id())->where('product_id',$prod_id)->first();
                if($existing_rating)
                {
                    $existing_rating->stars_rated = $stars_rated ;
                    $existing_rating->update();
                }else{
                    Rating::create([
                        'user_id'=> Auth::id(),
                        'product_id'=> $prod_id,
                        'stars_rated' => $stars_rated
                    ]);
                }
        return response()->json('done');

                // return $this->apiResponse(null,'DONE', 200);
            }else{
                return $this->apiResponse(null,'not authorized to rate product you didnt try it', 403);
            }
        }else{
            return $this->apiResponse(null,'Page Not Found', 404);
        }
    }
}
