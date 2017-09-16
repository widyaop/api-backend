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

Route::group(['namespace'=>'Api'], function(){
  Route::post('/register','UserController@register');
  Route::post('/login','UserController@login');

  Route::group(['middleware' => 'jwt.auth'], function(){
    Route::get('/post','PostController@getAllPost');
    Route::get('/post/{id}','PostController@getPost');
    Route::post('/post','PostController@createPost');
    Route::put('/post/{id}','PostController@updatePost');
    Route::delete('/post/{id}','PostController@deletePost');
  });
});
