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
           $current_user=auth()->user();
          if($current_user->role=="user"){
             $user=User::find($current_user->id);
             $wishlist=$user->products_wishlist()->get();
             return $wishlist;
          }
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
            $input["product_id"]=$request["id"];
            $input['user_id']=$user->id;
            $selectwishlist=Wishlist::where('user_id',$input['user_id'])
            ->where('product_id',$input["product_id"])->get();

            if(!count($selectwishlist)){
                $wishlist=Wishlist::create($input);

        }
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

       $user=auth()->user();
       if($user->role=="user"){
         $wishlist=Wishlist::where('user_id',$user->id)->where('product_id',$id)->delete();

        //  $delete=$wishlist->delete();
       }
    }

    public function deletewishlist()
    {
        $user=auth()->user();
        if($user->role=="user"){

        $delete=Wishlist::where('user_id',$user->id)->delete();

        }
    }


}
