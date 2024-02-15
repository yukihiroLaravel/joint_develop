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

Route::get('/', 'PostsController@index');

// ユーザー新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

Route::get('uses/{id}', 'UserController@index')->name('users.show');

// ログイン後
Route::group(['middleware' => 'auth'], function () {
  Route::prefix('users/{id}')->group(function () {
    Route::get('edit', 'UserController@edit')->name('users.edit');
    Route::put('', 'UserController@update')->name('users.update');
    Route::delete('', 'UserController@destroy')->name('user.delete');
  });

  Route::post('/', 'PostsController@store')->name('post.store');

  Route::post('follow/{id}', 'FollowController@follow')->name('follow');
  Route::delete('unfollow/{id}', 'FollowController@unfollow')->name('unfollow');
});
//ログイン
Route::get('login', 'Auth\LoginController@showLoginform')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
