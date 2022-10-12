<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\EmailVerification;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Symfony\Component\Mime\Email;
use Illuminate\Support\Facades\Storage;

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
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->except('user_role');
        $input['password'] = bcrypt($input['password']);
        $users = User::create($input);
        $role = $request->user_type == 2 ? "agent" : "client";
        $users->assignRole($role);
        \Mail::to($request->email)->send(
            new EmailVerification([
                "first_name" => $request->first_name,
                "last_name" => $request->last_name,
                "link" => env("APP_WEB_URL") . "/verify?token=" . $users->createToken('laravel-passport-auth')->accessToken
            ])
        );
        return response()->json(['message' => "Email Verification Sent."], $this->successStatus);
    }

    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password'),])) {
            $users = Auth::user();
            $success['Token'] =  $users->createToken('laravel-passport-auth')->accessToken;
            $success['user_id'] = $users->id;
            $success['user_name'] = $users->first_name;
            $success['user_role'] = $users->getRoleNames();
            return response()->json(["data" => $success], $this->successStatus);
        } else {
            return response()->json(['ERROR' => 'Unauthorised'], 401);
        }
    }

    public function UserDetails()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }
    public function index()
    {
        $users = User::paginate(5);
        return response()->json($users);
    }
    public function VerifyEmail()
    {

        if (Auth::user()) {
            $user = User::find(Auth::user()->id);
            $user->email_verified_at = now();
            $user->save();
            return response()->json(["message" => "verified"]);
        }

        return response()->json([
            "message" => "error link",
            "user" => Auth::user()
        ]);
    }

    public function EditProfile(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [

                'profile_picture' => 'nullable|image',
            ]);

            if ($validator->fails()) {
                $error = $validator->errors()->all()[0];
                return response()->json(['status => false', 'message' => $error, 'data' => []], 422);
            } else {
                $user = User::find($request->user()->id);
                if ($request->avatar && $request->avatar->isValid()) {
                    $filename = time() . '.' . $request->avatar->extenction();
                    $path = "public/images/$filename";
                    $user->avatar = $path;
                }

                $user->update($request->all());
                return response()->json(['status => true', 'message' => "Profile Updated.", 'data' => $user]);
            }
        } catch (\Exception $e) {
            return response()->json(['status => false', 'message' => $e->getMessage(), 'data' => []], 500);
        }
    }

    //users role
    public function viewUsersRoleAdmin()
    {
        $users = User::where('user_type', 1)->get(['id', 'first_name', 'last_name', 'email','user_type']); //admin
        return response()->json($users);
    }
    public function viewUsersRoleAgent()
    {
        $users = User::where('user_type', 2)->get(['id', 'first_name', 'last_name', 'email','user_type']); //agent
        return response()->json($users);
    }
    public function viewUsersRoleClient()
    {
        $users = User::where('user_type', 3)->get(['id', 'first_name', 'last_name', 'email','user_type']); //client
        return response()->json($users);
    }
}
