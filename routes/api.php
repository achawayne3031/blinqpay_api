<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});




///// Auth /////
Route::group(
    [
        'middleware' => ['cors'],
        'prefix' => 'auth',
        'namespace' => 'App\Http\Controllers',
    ],
    function ($router) {
        Route::post('/register', 'AuthController@register');
        Route::post('/login', 'AuthController@login');
    }
);


