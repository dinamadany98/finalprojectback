<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiResponseTrait;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;

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
        $current_user_id=1;
        $user=User::find($current_user_id);
           $cart=$user->products()->get();
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
        $user=auth()->user();
        if($user->role=="user"){

            $input=$request->all();
            $input['user_id']=$user->id;
            $cart=Cart::create($input);
            if($cart)
            return $this->apiResponse($cart,'DONE', 200);

        }

            return $this->apiResponse(null,'Error', 404);
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
        $user=auth()->user();
        if($user->role=="user"){
         $cart=Cart::where('user_id',$user->id)->find($id);
         $delete=$cart->delete();
         if($delete)
         return $this->apiResponse(null,'DONE', 200);
        }

         return $this->apiResponse(null,'Error', 404);
    }

      public function deletecart()
      {
         $user=auth()->user();

         $delete=Cart::where('user_id',$user->id)->delete();

         if($delete)
        return $this->apiResponse(null,'DONE', 200);
        return $this->apiResponse(null,'Error', 404);

       }
}
