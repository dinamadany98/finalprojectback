<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Models\Order;

class OrderItemController extends Controller
{
    public function index()
    {
        $orders=OrderItem::all();
        /*// $orders =OrderItem::all()->pluck('product_id');
         $orders =OrderItem::all()->pluck('order_id');
       
      */
         return $orders;



    }
    public function store(Request $request)
    {
        $input["user_id"]=$request["user_id"];
        $input["fname"]=$request["fname"];
        $input["lname"]=$request["lname"];
        $input["email"]=$request["email"];
        $input["phone"]=$request["phone"];
        $input["address1"]=$request["address1"];
        $input["address2"]=$request["address2"];
        $input["city"]=$request["city"];
        $input["state"]=$request["state"];
        $input["country"]=$request["country"];
        $input["pincode"]=$request["pincode"];
        $input["total_price"]=$request["total_price"];
        $input["status"]=$request["status"];
        $input["message"]=$request["message"];
        $stor=Order::create($input);
        $orders=Order::all()->pluck('id')->last();
        $inputs["order_id"]=$orders;
        $inputs["product_id"]=$request["product_id"];
        $inputs["quantity"]=$request["quantity"];
        $inputs["price"]=$request["price"];
        $stororderitem=OrderItem::create($inputs);
      
        if($stor && $stororderitem){
            return response()->json([
                "msg"=>"done"
            ]);
        }
    }
}
/*'order_id','product_id','quantity','price'
'user_id','fname','lname','email','phone','address1','address2','city',
              'state','country','pincode','total_price','status','message','tracking_no'*/