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

// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// ログインユーザ
Route::group(['middleware' => 'auth'], function () {
    // ユーザ編集
    Route::prefix('users/{id}')->group(function () {
        Route::get('', 'UsersController@edit')->name('users.edit');
        Route::put('', 'UsersController@update')->name('users.update');
    });
    // コメントポスト
    Route::post('posts', 'PostsController@post')->name('posts.post');
});

// 投稿削除
Route::delete('{id}', 'PostsController@destroy')->name('post.delete');