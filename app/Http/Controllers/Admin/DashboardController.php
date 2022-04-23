<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\ApiResponseTrait;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\Product;
use DB;


class DashboardController extends Controller
{
    use ApiResponseTrait;
    public function users()
    {
        $user=auth()->user();
        if($user->role=="admin" ||$user->role=="manager"){
        $users = User::all();
        return response()->json($users);
    }
    }
    public function show($id)
    {
        $userAuth=auth()->user();
        if($userAuth->role=="admin" ||$userAuth->role=="manager"){
            $order = Order::where('user_id',$id)->max('id');
            $getOrder = Order::where('id',$order)->with('user')->first();
            if($getOrder){
                return response()->json($getOrder);
            }else{
                return $this->apiResponse(null,'Error', 404);
            }
        }
    }
    public function update($id , Request $request)
    {
        $userAuth=auth()->user();
        if($userAuth->role=="admin" ||$userAuth->role=="manager"){
            $user = User::find($id);
            $user->role = $request->input('role');
            $user->update();
        return response()->json($user);
        }
    }

    ///admin_dashboard
    public function customers_number()
    {
        $user=User::where('role','user')->count();
        return response()->json($user);

    }

    public function users_number()
    {
        $user=User::count();
        return response()->json($user);
    }

    public function orders()
    {
        $currentdate=date('Y-m-d');

         $order= Order::whereDate('created_at',$currentdate)->count();
         return response()->json($order);
    }

    public function sales()
    {
        $totalprice=Order::where('status',1)->sum('total_price');
        return response()->json($totalprice);
    }


    public function rating()
    {


         $r=Rating::join('products','ratings.product_id','products.id')
         ->select('stars_rated', 'product_id','name','image','small_description')
        ->selectRaw(' (count(*) * stars_rated) as rate')
        ->selectRaw('count(*) as count')
        ->groupBy('stars_rated', 'product_id')->get();

        /*$r=$r->select('product_id')
        ->selectRaw('sum(rate)/sum(count) as total ')
        ->groupBy('product_id')->get();*/

          $array=array();
          $arraycount=array();
          foreach($r as $starsrated)
          {

            if(!array_key_exists($starsrated->product_id, $array))
            {
                $array[$starsrated->product_id] = 0;
            }

            if(!array_key_exists($starsrated->product_id, $arraycount))
            {
                $arraycount[$starsrated->product_id] = 0;
            }
            $array[$starsrated->product_id]+=$starsrated->rate;
            $arraycount[$starsrated->product_id]+=$starsrated->count;

           }

           foreach($array as $key=>$value)
           {
            $array[$key]/=$arraycount[$key];

           }
           $rate=array();
           $check=array();
          foreach($r as $starsrated)
          {

             if(!in_array($starsrated->product_id,$check)){
                array_push($check,$starsrated->product_id);
                 array_push($rate,
                  [
                    'rate'=>$array[$starsrated->product_id]*10,
                      'name'=>$starsrated->name,
                      'image'=>$starsrated->image,
                      'description'=>$starsrated->small_description
                  ]
              );

          }
        }


        return response()->json($rate);

    }


}
