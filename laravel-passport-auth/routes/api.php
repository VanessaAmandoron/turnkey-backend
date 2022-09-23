<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\VerificationController;
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
    Route::get('user-details', [AuthController::class, 'userDetails']);
    Route::get('users', [AuthController::class, 'user/index']);

});
Route::apiResource('property', PropertyController::class)->middleware("auth:api");  

Route::post('image', [ImageController::class, 'imageStore']);

Route::group(['middleware' => 'auth:api'], function(){

    Route::post('email/verification-notification', [VerificationController::class, 'sendVerificationEmail'])->middleware('auth:api');
    Route::get('verify-email/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:api');


});





