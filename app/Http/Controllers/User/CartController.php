<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiResponseTrait;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    use ApiResponseTrait;
    public function index()
    {
        $current_user_id=Auth::id();
          $cart_details=Cart::where('user_id',$current_user_id)->get();
        return $cart_details;
        /*
         $current_user=auth()->user();
        if($current_user->role=="user"){
           $user=User::find($current_user->id);
           $cart=$user->products()->get();
          $cart_details=Cart::where('user_id',$current_user->id)->get();
         if($cart)
         return $this->apiResponse([$cart,$cart_details],'DONE', 200);
        }

        return $this->apiResponse(null,'Error', 404);
*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
       $quantity=Product::where('id','=',$request["id"])->value('quantity');
       $cartcountaty=Cart::where("product_id",$request["id"])->value("prod_qty");
        $selectcartprod=Cart::where("product_id",$request["id"])->get();
    if($quantity>$cartcountaty){
        if(count($selectcartprod)){
            Cart::where('product_id','=',$request["id"])->increment('prod_qty',1);

        }else
        {
            $userid= Auth::id();
            $input=$request->all();
            $input['user_id']=$userid;
            $input['product_id']=$request["id"];
            $input['prod_qty']=1;
            $cart=Cart::create($input);
        }

    }
        /*
        $user=auth()->user();
        if($user->role=="user"){

            $input=$request->all();
            $input['user_id']=$user->id;
            $cart=Cart::create($input);
            if($cart)
            return $this->apiResponse($cart,'DONE', 200);

        }

            return $this->apiResponse(null,'Error', 404);
    */
        }

        public function  decrement($prodid)
        {

            $selectcartprod=Cart::where("product_id",$prodid)->get();
            if(count($selectcartprod)){
                Cart::where('product_id','=',$prodid)->decrement('prod_qty',1);

            }

        }
        public function  increment($prodid)
        {

            $selectcartprod=Cart::where("product_id",$prodid)->get();
            if(count($selectcartprod)){
                Cart::where('product_id','=',$prodid)->increment('prod_qty',1);

            }

        }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
         public function show()
         {

        }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user=auth()->user();
         if($user->role=="user"){
           $cart=Cart::find($id);
           $editcart=$cart->update($request->all());
           if($editcart)
           return $this->apiResponse($editcart,'DONE', 200);
         }

            return $this->apiResponse(null,'Error', 404);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $userid= Auth::id();
        $cart=Cart::where('user_id',$userid)->find($id);
        $delete=$cart->delete();

        /*
        $user=auth()->user();
        if($user->role=="user"){
         $cart=Cart::where('user_id',$user->id)->find($id);
         $delete=$cart->delete();
         if($delete)
         return $this->apiResponse(null,'DONE', 200);
        }

         return $this->apiResponse(null,'Error', 404);
         */
    }

      public function deletecart()
      {
         //$user=auth()->user();
         $userid= Auth::id();
         $delete=Cart::where('user_id',$userid)->delete();
/*
         if($delete)
        return $this->apiResponse(null,'DONE', 200);
        return $this->apiResponse(null,'Error', 404);
*/
       }

}
