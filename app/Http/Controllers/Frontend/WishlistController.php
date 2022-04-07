<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\User;
use App\Models\Product;
class WishlistController extends Controller
{   

    public function index()
    {
        
     }


    public function store(Request $request)
    { 
        
        $Wishlist=Wishlist::create($request->all());
      
        if($Wishlist){
            return response()->json([
                "msg"=>"done"
            ]);
        }

    }
    public function show(Wishlist $Wishlist)
    {
       $Wishlist=Wishlist::find($Wishlist)->all();
      $data=product->all();
        //$id=1;
       // $data=$id->product->get();
       // $data=$id->produc->all();
       
        dd($data);

    } 

    public function destroy(Wishlist $Wishlist)
    {
        $delet= $Wishlist->delete();
        if($delet){
            return response()->json([
                "msg"=>"done"
            ]);
        }
    }
    public function deletallwishlist()
    {
        $Wishlist=Wishlist::where('user_id',1)->delete();
       // dd($Wishlist);
       // $delet=$Wishlist->delete();
        if($Wishlist){
            return response()->json([
                "msg"=>"done"
            ]);
        }
    }



}
