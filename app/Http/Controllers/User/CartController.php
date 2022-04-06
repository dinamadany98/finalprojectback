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
            $cart=Cart::create($request->all());
            if($cart)
            return $this->apiResponse($cart,'DONE', 200);

            return $this->apiResponse(null,'Error', 404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
      public function show($user_id)
       {
           $user=User::find($user_id);
          $cart=$user->products()->get();
           if($cart)
            return $this->apiResponse($cart,'DONE', 200);

            return $this->apiResponse(null,'Error', 404);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $cart=Cart::find($id);
         $delete=$cart->destroy();
         if($delete)
         return $this->apiResponse(null,'DONE', 200);

         return $this->apiResponse(null,'Error', 404);
    }
}
