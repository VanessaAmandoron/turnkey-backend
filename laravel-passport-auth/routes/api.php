<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AddPropertyController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Admin\AdminUserController;
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
    Route::post('user-details', [AuthController::class, 'userDetails']);
   });

Route::apiResource('add_property', AddPropertyController::class);
Route::post('image', [ImageController::class, 'imageStore']);


// $api->group(['middleware' => ['role:admin'], 'prefix' => 'admin'], function ($api) {
//     $api->get('/users', 'App\Http\Controllers\Admin\AdminUserController@index');
// });

Route::group(['middleware' => 'role:admin', 'auth:api'], function () {
    Route::get('/users', [AdminUserController::class, 'index']);
});

