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





///// Promotional Ads //////
Route::group(
    [
        'middleware' => ['cors', 'auth.passport', 'auth:api'],
        'prefix' => 'posts',
        'namespace' => 'App\Http\Controllers',
    ],
    function ($router) {
        Route::post('/create-post', 'PostController@create_post');
        Route::post('/delete-post', 'PostController@delete_post');
        Route::post('/update-post', 'PostController@update_post');
        Route::get('/all-posts', 'PostController@all_post');
        Route::get('/view-post/{post_id}', 'PostController@view_post');


    }
);



