<?php

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
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/', function () {
    return view('welcome');
});
//ユーザ登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

//ユーザー編集、更新
Route::group(['prefix' => 'users'], function () {
    Route::post('', 'UsersController@store')->name('user.store');
    Route::get('{id}/edit', 'UsersController@edit')->name('user.edit');
    Route::put('{id}', 'UsersController@update')->name('user.update');
});
