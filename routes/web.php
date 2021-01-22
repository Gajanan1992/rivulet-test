<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/posts', 'PostController@index');
Route::get('/post/create', 'PostController@create');
Route::get('/post/show/{id}', 'PostController@show');
Route::get('/post/edit/{id}', 'PostController@edit');

Route::get('/login', 'HomeController@login');
Route::get('/register', 'HomeController@register');

