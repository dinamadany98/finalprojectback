<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\User;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Mail\accessmail;
use Illuminate\Support\Facades\Mail;
class OrderItemController extends Controller
{
    public function index()
    {

        $OrderItem=OrderItem::get();
        $orders=Order::all();
        $arr=[];
        foreach($orders as $key => $value){

            $data=$value->productss()->get();
            $data2=$data->pluck("pivot.order_id")[0];

            $data3=$data->pluck("pivot.product_id");
           $OrderItem=OrderItem::whereIn('product_id',$data3)->
           where('order_id',$data2)
           ->get();

           // $OrderItem=OrderItem::where(['order_id'=>$data->order_id,'product_id'=>$data->product_id])->get();
          // $datas=$data->join('order_items', 'data.order_id', '=', 'order_items.order_id');
          // dd($OrderItem);
           $dat=array_push($arr,[$data,$OrderItem]);
        }




return $arr;
    }
    public function store(Request $request)
    {
        $input["user_id"]= Auth::id();
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
        $input["tracking_no"]='order' .' '.random_int(100000, 999999);
        $input["message"]=$request["message"];
        $cart=Cart::get();
        $totalpricetotal=0;
        foreach($cart as $key => $value){
            
       $price=Product::where('id','=',$value->product_id)->value('selling_price');
       Product::where('id','=',$value->product_id)->decrement('quantity',$value->prod_qty);
            $totalpricetotal +=$price * $value->prod_qty;
        }
        $input["total_price"]=$totalpricetotal;
        $stor=Order::create($input);
        $orders=Order::all()->pluck('id')->last();
      $cart=Cart::get();
      foreach($cart as $key => $value){
       $price=Product::where('id','=',$value->product_id)->value('selling_price');
      Product::where('id','=',$value->product_id)->decrement('quantity',$value->prod_qty);
       $totalprice=$price * $value->prod_qty;
     
        OrderItem::create([
            'order_id'=>$orders,
            'product_id'=>$value->product_id,
            'quantity'=>$value->prod_qty,
            'price'=>$price,
            'total_price'=>$totalprice,
        ]);
      }
      Cart::where('user_id', Auth::id())->delete();
        // $details = $value->product_id;
        $details = $totalprice;
        Mail::to($input["email"])->send(new accessmail($details));
        return response()->json('done');

        if($stor){
            return response()->json([
                "msg"=>"done"
            ]);
        }
    }



    public function show()
    {


    }
    public function getuserorder()
    {
        $userid= Auth::id();
        // dd($userid);
        $user=User::find($userid);
         $data=$user->Order()->get()->pluck("id");
        $Order=OrderItem::whereIn("order_id",$data)->get();
        //$d= $data->productss()->get();
         //dd($Order);
         return $Order;
    }
    public function getorderforspasificuser()
    {
        $userid= Auth::id();
        // dd($userid);

        $orders=Order::where("user_id",$userid)->get();
        return $orders;
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
        public function updatestatus($id)
        {
            Order::where('id','=',$id)->update(array('status' => '1'));

        }
      
}
