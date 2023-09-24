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

// トップページPOSTS一覧表示
Route::get('/', 'UsersController@index')->name('home');

// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// ユーザ情報詳細
Route::get('users/{id}', 'UsersController@show')->name('users.show');
Route::get('users/{id}/edit', 'UsersController@edit')->name('users.edit');
Route::put('users', 'UsersController@update')->name('users.update');
Route::delete('users/{id}', 'UsersController@destroy')->name('users.delete');

// ポスト管理
Route::post('posts/{id}', 'PostsController@index')->name('posts.post');
Route::get('posts/{id}/edit', 'PostsController@edit')->name('posts.edit');
Route::put('posts/{id}', 'PostsController@update')->name('posts.update');
Route::delete('posts/{id}', 'PostsController@destroy')->name('posts.delete');

