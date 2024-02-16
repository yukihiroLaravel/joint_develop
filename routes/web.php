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

Route::get('/', 'UsersController@index');

// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
// ログイン後
Route::group(['middleware' => 'auth'], function () {
    // 投稿
    Route::prefix('posts')->group(function () {
        Route::post('/', 'PostsController@store')->name('post.store');
    });
    //ユーザ詳細
    Route::get('users/{id}', 'UsersController@show')->name('user.show');
    // ユーザ編集・更新
    Route::group(['prefix' => 'users'],function(){
        Route::get('{id}/edit', 'UsersController@edit')->name('users.edit');
        Route::put('{id}', 'UsersController@update')->name('users.update');
    });
});