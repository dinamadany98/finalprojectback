<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\ApiResponseTrait;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    use ApiResponseTrait;
    public function users()
    {
        $user=auth()->user();
        if($user->role=="admin"){
        $users = User::all();
        return response()->json($users);
    }
    }
    public function show($id)
    {
        $userAuth=auth()->user();
        if($userAuth->role=="admin"){
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
        if($userAuth->role=="admin"){
            $user = User::find($id);
            $user->role = $request->input('role');
            $user->update();
        return response()->json($user);
        }
    }
}
