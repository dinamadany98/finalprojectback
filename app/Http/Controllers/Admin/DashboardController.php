<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function users()
    {
        $user=auth()->user();
        if($user->role=="admin" ||$user->role=="manager"){
        $users = User::all();
        return response()->json($users);
    }
    }
    public function viewuser($id)
    {
        $user=auth()->user();
        if($user->role=="admin" ||$user->role=="manager"){
        $user = User::find($id);
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
        return response()->json(DAY());
        $orders=Order::where(DAY(`created_at`),CURDATE())->get();
        //->count();
        //return response()->json(1);
        return response()->json($orders);
    }


}
