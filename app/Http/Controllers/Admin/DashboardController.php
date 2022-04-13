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
    public function viewuser($id)
    {
        $user=auth()->user();
        if($user->role=="admin"){
        $user = User::find($id);
        return response()->json($user);
        }
    }
}
