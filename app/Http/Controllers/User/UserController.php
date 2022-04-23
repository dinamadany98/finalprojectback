<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // $user=auth()->user();
        $userid= auth()->user();
        return response()->json($userid);

    }



    public function show($userid)
    {
        // $user=auth()->user();
        $userid = auth()->user();
        return response()->json($userid);


    }



    public function update(Request $request, User $user)
    {
        $request['password']= Hash::make($request["password"]);
        $user->update($request->all());


    }
    public function destroy(User $user)
    {
        $user->delete();

    }
}
