<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\SendContactDetailsController;
use App\Models\SendContactDetails;
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
      
    
    Route::get('property/restore/{id}', [PropertyController::class, 'restore']);//admin

    //Route::get('search-property/{title}', [PropertyController::class, 'SearchProperty']); //deleted

    Route::delete('users/delete/{id}', [AuthController::class, 'delete']);
    Route::get('users/restore/{id}', [AuthController::class, 'restore']);
    
    Route::get('users-role/agent', [AuthController::class, 'viewUsersRoleAgent']);
    Route::get('users-role/client', [AuthController::class, 'viewUsersRoleClient']);
    Route::get('property-list', [PropertyController::class, 'AgentHasProperty']);
    Route::get('property', [PropertyController::class, 'index']);
    Route::get('property/{id}', [PropertyController::class, 'show']);

    Route::post('property/contact/{id}', [SendContactDetailsController::class, 'create']);//new
});


//Agent Route
Route::group(['middleware' => ['auth:api', 'role:agent']], function(){ //'role:agent|admin'
    Route::post('property-create', [PropertyController::class, 'store']);
    Route::put('property-edit', [PropertyController::class, 'update']);
    Route::delete('property-delete', [PropertyController::class, 'destroy']);//agent, admin

});
Route::post('image', [ImageController::class, 'imageStore']);

