<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Api\ApiResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\User;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    use ApiResponseTrait;

    public function index()
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
           $wishlist=Wishlist::create($request->all());
            if($wishlist)
            return $this->apiResponse($wishlist,'DONE', 200);

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
             $wishlist=$user->products_wishlist()->get();
             if($wishlist)
             return $this->apiResponse($wishlist,'DONE', 200);

            return $this->apiResponse(null,'Error', 404);
       }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_id=2;
        $wishlist=Wishlist::where(['id'=>$id ,'user_id'=>$user_id])->first();
       // return $this->apiResponse($wishlist,'DONE', 200);
        $delete=$wishlist->destroy();
        if($delete)
        return $this->apiResponse(null,'DONE', 200);

        return $this->apiResponse(null,'Error', 404);
    }
}
