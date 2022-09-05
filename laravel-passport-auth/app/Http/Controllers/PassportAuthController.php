<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class PassportAuthController extends Controller
{
     public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:8',
            'full_name' => 'required|min:4',
        ]);
 
        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'full_name' => $request->full_name,
            'p_number' => $request->p_number,
            'user_type' => $request->user_type
        ]);
       
        $token = $user->createToken('LaravelAuthApp')->accessToken;
 
        return response()->json(['token' => $token], 200);
    }
}
