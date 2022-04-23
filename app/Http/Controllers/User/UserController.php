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
        $user=auth()->user();
        //$userid = auth()->user();


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
     

     public function showuser($userid)
     {
        $user=User::find($userid);
        return response()->json($user);

     }

     public function updatepassword(Request $request)
     {

        $user= User::where('email',$request['email'])->firstOrFail();
         $request['password']=Hash::make($request['password']);
         $user=$user->update($request->all());
         return response()->json('done');
     }
}
