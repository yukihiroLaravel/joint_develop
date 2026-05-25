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
// ユーザ登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
// ユーザ登録（作成時）
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// ユーザ詳細
Route::prefix('users')->group( function() {
    Route::get('{id}', 'UsersController@show')->name('user.show');
});

// ログイン後に可能な処理のグループ
Route::group(['middleware' => 'auth'], function() {
    Route::delete('users/{id}', 'UsersController@destroy')->name('user.delete'); //退会
    Route::prefix('posts')->group( function() {
        Route::get('{id}/edit', 'PostsController@edit')->name('post.edit'); //投稿編集
        Route::put('{id}', 'PostsController@update')->name('post.update'); //投稿更新
    });
});