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
Route::get('signup','Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup','Auth\RegisterController@register')->name('signup.post');

//ユーザー詳細
Route::prefix('users')->group(function(){
    Route::get('{id}', 'UsersController@show')->name('user.show');
});
// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// ログイン後（ログイン後にしか3つのルートにアクセスできない。）
Route::group(['middleware' => 'auth'], function () {
    // 投稿
    Route::prefix('posts')->group(function () {
        Route::post('/', 'PostsController@store')->name('post.store');
        Route::get('{id}/edit', 'PostsController@edit')->name('post.edit');
        Route::put('{id}', 'PostsController@update')->name('post.update');
    });
    // ユーザ　
    Route::prefix('users')->group(function () {
        Route::get('{id}/edit', 'UsersController@edit')->name('user.edit');
        Route::put('{id}', 'UsersController@update')->name('user.update');
        Route::delete('{id}','UsersController@destroy')->name('user.delete');
        Route::get('{id}','UsersController@show')->name('user.show');
    });
    // フォロー
     Route::group(['prefix' => 'users/{id}'],function() {
        Route::post('follower','FollowerController@store')->name('follower');
        Route::delete('unfollower','FollowerController@destroy')->name('unfollower');
     });
});

// トップページの投稿表示
Route::get('/', 'PostsController@index');

// フォロー
Route::get('users/{id}/followers','UsersController@folloowers')->name('user.followers');
