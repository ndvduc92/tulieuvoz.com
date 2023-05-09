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

Route::get('/', 'HomeController@index');

Route::get('/links', 'HomeController@getLinks');
Route::post('/links', 'HomeController@postLink');
Route::get('/link/{id}', 'HomeController@getLink');
Route::get('/link/{id}/vote', 'HomeController@voteLink')->middleware("throttle:5,1");
Route::post('/link/{id}/comment', 'HomeController@postComment');

Route::get('/user/{id}', 'HomeController@getUser')->name('user');
Route::get('/users', 'HomeController@getUsers')->name('users');


Route::get('/iframe', 'HomeController@iframe');

Route::get('login', 'AuthController@login')->name('login');
Route::post('login', 'AuthController@postLogin');
Route::get('register', 'AuthController@register');
Route::post('register', 'AuthController@postRegister');
Route::get('logout', 'AuthController@logout');

Route::group(['middleware'=>'auth'], function(){
    Route::get('/link/{id}/like', 'HomeController@addLike');
    Route::get('manage', 'UserController@dashboard');
    Route::get('likes', 'UserController@likes');
    Route::get('manage/{id}/edit', 'UserController@edit');
    Route::post('manage/{id}/edit', 'UserController@update');
    Route::get('manage/{id}/delete', 'UserController@delete');
});

