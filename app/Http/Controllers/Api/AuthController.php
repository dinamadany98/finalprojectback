<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
     public function register(Request $request)
    {
        $input = $request->validate([
            'name'=>'required | string',
            'email'=>'required | string | email | unique:users,email',
            'password' => 'required ' ,
            'role' =>'required'
        ]);
        $user= User::create([
            'name'=>$input["name"],
            'email'=>$input["email"],
            'password' =>Hash::make($input["password"]),
            'role' =>$input['role']
        ]);

        $token = $user->createToken('usertoken')->plainTextToken;
        $response =[
                    "status"=>true,
                    "msg"=>"done",
                    "data"=>[
                        'user'=>$user,
                        'token'=>$token
                    ]
        ];
        return response($response,201);
    }

         public function login(Request $request){
         $user= User::where('email',$request['email'])->firstOrFail();

         $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(
            [
                "msg"=>"done",
                "token"=>$token
            ]);
    }
}
