<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;

class ForgetPasswordController extends Controller
{
    public function resetPassword(Request $request)
    {
        $user= User::where('email',$request['email'])->firstOrFail();
        if($user&&$user->role!='user'){
        $newpassword=Str::random(6);
        $details=
        [
            'title'=>'Password Reset',
            'body'=>"Your new password is : $newpassword"

        ];

        $result=Mail::to($request['email'])->send(new ResetPasswordMail($details));
        //if($result)
        return response()->json( $newpassword);
        }
        return response()->json('error');
    }
}
