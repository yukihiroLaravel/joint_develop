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

// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');
Route::get('/', 'PostsController@index');

// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('users/{id}', 'UsersController@show')->name('user.show');

// ログイン後
Route::group(['middleware' => 'auth'], function () 
{
    // ユーザ情報編集
    Route::prefix('users')->group(function () {
        Route::get('{id}/edit', 'UsersController@edit')->name('users.edit');
        Route::put('{id}', 'UsersController@update')->name('users.update');
    });
    //投稿新規作成
    Route::prefix('posts')->group(function () {
        Route::post('', 'PostsController@store')->name('post.store');
    });
});