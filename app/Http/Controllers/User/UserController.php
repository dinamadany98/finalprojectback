<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    public function show($userid)
    {
        $user=User::find($userid);
        return $user;
    
    }
    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        
    }
    public function destroy(User $user)
    {
        $user->delete();

    }
}
