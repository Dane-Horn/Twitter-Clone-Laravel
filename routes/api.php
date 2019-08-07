<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/comp', 'AuthController@comp');

Route::post('/user/register', 'AuthController@register');
Route::post('/user/login', 'AuthController@login');
Route::post('/user/logout', 'AuthController@logout');
Route::get('/user/me', 'AuthController@me');
Route::get('/user/feed', 'PostController@feed');


Route::get('/posts/own', 'PostController@own');

Route::post('/follow/{id}', 'FollowingController@follow');
Route::post('/user/following', 'FollowingController@getFollowing');

Route::post('/tweet', 'TweetController@create');
Route::delete('/tweet/{id}', 'TweetController@destroy');
Route::post('/tweet/{id}/reply', 'TweetController@reply');

Route::post('/retweet/{id}', 'RetweetController@create');
Route::delete('/retweet/{id}', 'RetweetController@destroy');