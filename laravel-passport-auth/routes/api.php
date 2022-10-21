<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\SendContactDetailsController;
use App\Http\Controllers\Api\NewPasswordController;
use App\Http\Controllers\Api\SubscriptionController;

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

Route::get('property', [PropertyController::class, 'clientViewProperty']);//for client and user property list

Route::post('forgot-password', [NewPasswordController::class, 'forgotPassword']);
Route::post('reset-password', [NewPasswordController::class, 'reset']);

Route::get('subscription-list', [SubscriptionController::class, 'SubscriptionList']);//admin subcription list of agents
Route::get('property/{id}', [PropertyController::class, 'showProperty']);
Route::group(['middleware' => 'auth:api'], function(){
    Route::post('verify', [AuthController::class, 'VerifyEmail']);
});
Route::group(['middleware' => ['verified','auth:api']], function(){
   
    Route::get('profile', [AuthController::class, 'UserDetails']);
    Route::put('profile/edit', [AuthController::class, 'EditProfile']);
    Route::get('users', [AuthController::class, 'index']);
    Route::get('users/{id}', [AuthController::class, 'GetUser']);

    Route::get('property/restore/{id}', [PropertyController::class, 'restore']);//admin||agent
    Route::delete('property/delete/{id}', [PropertyController::class, 'delete']);//admin||agent
    //Route::get('search-property/{title}', [PropertyController::class, 'SearchProperty']); //deleted
    Route::get('admin/property-list', [PropertyController::class, 'PropertyListForAdmin']);
    Route::get('admin/users-list', [AuthController::class, 'UserListForAdmin']);
    Route::delete('users/delete/{id}', [AuthController::class, 'delete']);
    Route::get('users/restore/{id}', [AuthController::class, 'restore']);
    
    Route::get('users-role/agent', [AuthController::class, 'viewUsersRoleAgent']);
    Route::get('users-role/client', [AuthController::class, 'viewUsersRoleClient']);
    Route::get('property-list', [PropertyController::class, 'AgentProperty']);
    Route::get('agent/contacts/history', [SendContactDetailsController::class, 'AgentTransactionHistory']);//for agentTransactionHistory
    Route::get('admin/contacts/history', [SendContactDetailsController::class, 'AdminTransactionHistory']);//for adminTransactionHistory
    Route::get('agent/contacts', [SendContactDetailsController::class, 'index']);//conatact list
    Route::get('property/contact/{id}', [SendContactDetailsController::class, 'create']);//send details to table
    Route::delete('agent/contacts/delete/{id}', [SendContactDetailsController::class, 'destroy']);//new
    Route::post('agent/subscription/{id}', [SubscriptionController::class, 'AgentSubcription']);//agent subcription
    Route::post('admin/create-subscription', [SubscriptionController::class, 'AdminCreateSubcription']);//agent subcription
    Route::get('admin/subscription-list', [SubscriptionController::class, 'AdminSubscriptionList']);//admin subcription list
    Route::get('agent/subscription-info', [SubscriptionController::class, 'index']);//agent subcription information
    Route::put('agent/subscription/edit/{id}', [SubscriptionController::class, 'EditAgentSubcription']);//agent edit subcription
    Route::delete('agent/subscription/delete', [SubscriptionController::class, 'CancelSubscription']);//agent cancel subcription
    Route::get('agent/dashboard', [PropertyController::class, 'AgentDashboard']);//agent dashboard    
    Route::get('admin/agent-list/', [SubscriptionController::class, 'agentSubsList']);//admin subcription list of agents who subs
    
    
    Route::post('property-create', [PropertyController::class, 'createProperty']);
    Route::apiResource('properties', PropertyController::class); //edit properties ni
    // Route::put('property-edit/{id}', [PropertyController::class, 'update']);
    Route::delete('property-delete', [PropertyController::class, 'destroyProperty']);//agent, admin
    
});
    