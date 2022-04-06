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
        $input["message"]=$request["message"];
        $stor=Order::create($input);
        $orders=Order::all()->pluck('id')->last();
        $inputs["order_id"]=$orders;
        $inputs["product_id"]=$request["product_id"];
        $inputs["quantity"]=$request["quantity"];
        $inputs["price"]=$request["price"];
        $inputs["status"]=$request["status"];
        $inputs["total_price"]=$inputs["quantity"] * $inputs["price"];
        dd($inputs["total_price"]);
        $stororderitem=OrderItem::create($inputs);
      
        if($stor && $stororderitem){
            return response()->json([
                "msg"=>"done"
            ]);
        }
    }
    public function update(Request $request, OrderItem $OrderItem)
    {
        
         $input= $request->all();
        $input["total_price"]=$request["quantity"] * $request["price"];
      
       $inputs=$OrderItem->update($input);
       
        if($inputs){
            return response()->json([
                "msg"=>"done"
            ]);
        }
    }
        public function destroy(OrderItem $OrderItem)
        {
            $delet= $OrderItem->delete();
            if($delet){
                return response()->json([
                    "msg"=>"done"
                ]);
            }
           
       
        }    
   
}
