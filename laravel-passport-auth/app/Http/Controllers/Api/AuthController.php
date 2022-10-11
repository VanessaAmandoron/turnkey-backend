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
use Laravel\Passport\Passport;

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
            'profile_picture' => 'nullable',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
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

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password'),])) {
            $users = Auth::user();

            if (!$request->remember_me) {
                Passport::personalAccessTokensExpireIn(now()->addHour(24));
            }

            $success['Token'] =  $users->createToken('laravel-passport-auth')->accessToken;
            $success['user_id'] = $users->id;
            $success['user_name'] = $users->first_name;
            $success['user_role'] = $users->user_type;
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
        $users = User::paginate(20);
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
                if ($request->profile_picture && $request->profile_picture->isValid()) {
                    $filename = time() . '.' . $request->profile_picture->extenction();
                    $path = "public/images/$filename";
                    $user->profile_picture = $path;
                }

                $user->update($request->all());
                return response()->json(['status => true', 'message' => "Profile Updated.", 'data' => $user]);
            }
        } catch (\Exception $e) {
            return response()->json(['status => false', 'message' => $e->getMessage(), 'data' => []], 500);
        }
    }

    //start delete users
    public function delete($id)
    {
        $users = User::find($id);
        $users->delete();
        return response()->json(['message' => "User Successfully Deleted.", 'data' => $users]);
    }
    //end delete users
    //start restore users
    public function restore($id)
    {
        User::withTrashed()->find($id)->restore();
        $users = User::find($id);
        return response()->json(['message' => "User Successfully Restored.", 'data' => $users]);
    }
    //end restore users

    //users role
    public function viewUsersRoleAdmin()
    {
        $users = User::where('user_type', 1)->paginate(20);
        return response()->json(
            [
                'message' => "List of admins.",
                $users
            ]
        ); //admin
    }
    public function viewUsersRoleAgent()
    {
        $users = User::where('user_type', 2)->paginate(20);
        return response()->json(
            [
                'message' => "List of agents.",
                $users
            ]
        ); //agent
    }
    public function viewUsersRoleClient()
    {
        $users = User::where('user_type', 3)->paginate(20);
        return response()->json(
            [
                'message' => "List of clients.", $users,

            ]
        ); //client
    }
}
