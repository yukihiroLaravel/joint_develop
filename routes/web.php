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

//ユーザー新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// トップページ表示
Route::get('/', 'PostsController@index'); //追記
Route::get('/', 'PostsController@index')->name('welcome');//トップページへの遷移

// ログイン後
Route::group(['middleware' => 'auth'], function () {
    Route::prefix('users')->group(function() {
        // ユーザ編集/更新
        Route::get('{id}/edit', 'UsersController@edit')->name('user.edit');
        Route::put('{id}', 'UsersController@update')->name('user.update');
        // ユーザ退会
        Route::delete('{id}', 'UsersController@destroy')->name('user.delete');
        // ユーザ詳細
        Route::get('{id}', 'UsersController@show')->name('user.show');
    });

    Route::prefix('posts')->group(function() {
        // 投稿投稿作成/編集/更新
        Route::post('', 'PostsController@store')->name('post.store');
        Route::get('{id}/edit', 'PostsController@edit')->name('post.edit');
        Route::put('{id}', 'PostsController@update')->name('post.update');
        // 投稿削除
        Route::delete('{id}', 'PostsController@destroy')->name('post.delete');
    });
});