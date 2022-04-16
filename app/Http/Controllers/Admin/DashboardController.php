<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\ApiResponseTrait;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

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
        $currentdate=Carbon::now()->format('Y-m-d');
       $orders=Order::where([DATE_FORMAT('created_at','Y-m-d')=>$currentdate,'status'=>1])->count();
        //->count();
        //return response()->json(1);
        return response()->json($orders);
    }

    public function sales()
    {
        $totalprice=Order::where('status',1)->sum('total_price');
        return response()->json($totalprice);
    }


}
