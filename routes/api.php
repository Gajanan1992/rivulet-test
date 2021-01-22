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

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/logout', 'Api\ApiAuthController@logout');

    Route::get('/posts', 'PostController@getAllPosts');
    Route::post('/posts/store', 'PostController@storePost');
    Route::post('/posts/comment', 'PostController@storeComment');
    Route::post('/posts/update/{id}', 'PostController@updatePost');
    Route::get('/post/{id}', 'PostController@getPost');
    Route::get('/comments/{id}', 'PostController@getPostComments');
});
Route::post('/register', 'Api\ApiAuthController@register');
Route::post('/login', 'Api\ApiAuthController@login')->name('login');

