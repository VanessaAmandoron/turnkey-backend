<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ImageController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// $api = app('Dingo\Api\Routing\Router');

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::group(['middleware' => 'auth:api'], function(){
    Route::get('profile', [AuthController::class, 'UserDetails']);
    Route::put('profile/edit', [AuthController::class, 'EditProfile']);
    Route::get('users', [AuthController::class, 'index']);
    Route::post('verify', [AuthController::class, 'VerifyEmail']);
    Route::apiResource('property', PropertyController::class);  
    
    Route::get('property/restore/{id}', [PropertyController::class, 'restore']);
    Route::get('property-list', [PropertyController::class, 'AgentHasProperty']);
    Route::get('property-count', [PropertyController::class, 'CountProperty']);
    Route::get('search-property-title/{title}', [PropertyController::class, 'SearchProperty']);

    Route::delete('users/delete/{id}', [AuthController::class, 'delete']);
    Route::get('users/restore/{id}', [AuthController::class, 'restore']);
    
    Route::get('users-role/admin', [AuthController::class, 'viewUsersRoleAdmin']);
    Route::get('users-role/agent', [AuthController::class, 'viewUsersRoleAgent']);
    Route::get('users-role/client', [AuthController::class, 'viewUsersRoleClient']);
});

Route::post('image', [ImageController::class, 'imageStore']);

