<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public $successStatus = 200;

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
            'first_name' => 'required',
            'last_name' => 'required',
            'user_type' => 'required',
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401); 
        }

        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $users = User::create($input); 
        $users->assignRole($request->input('roles'));
        $success['name'] =  $users -> first_name;
        $success['token'] =  $users->createToken('laravel-passport-auth')-> accessToken; 
        return response()->json(['Successfully created an account.'=>$success], $this-> successStatus); 
    }
       
    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password'), ])){ 
            $users = Auth::user(); 
            $success['Token'] =  $users->createToken('laravel-passport-auth')-> accessToken; 
            $success['User ID:'] = $users->id;
            $success['User Name:'] = $users->first_name;
            return response()->json(['Successfully Logged In.' => $success], $this-> successStatus); 
        } 
        
        else{ 
            return response()->json(['ERROR'=>'Unauthorised'], 401); 
        } 
    }

    public function userDetails() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user], $this-> successStatus); 
    }
}
