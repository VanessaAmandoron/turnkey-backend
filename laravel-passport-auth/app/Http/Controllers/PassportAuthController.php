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
            'first_name' => 'required',
            'last_name' => 'required',
        ]);
 
        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'p_number' => $request->p_number,
            'user_type' => $request->user_type
        ]);
       
        $token = $user->createToken('LaravelAuthApp')->accessToken;
 
        return response()->json('User Created Successfully!');
        return response()->json(['token' => $token], 200);
    }
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
 
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            return response()->json('Login Successfully!');
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
}
