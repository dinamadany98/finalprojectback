<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
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
            $user = User::where('id',$id)->with('Order')->first();
            if($user){
                return response()->json($user);
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
