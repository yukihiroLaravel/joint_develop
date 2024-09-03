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

Route::get('/', 'UsersController@index')->name('welcome');

// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ユーザ
Route::prefix('users/{id}')->group(function () {
    Route::get('', 'UsersController@show')->name('user.show');
    Route::delete('', 'UsersController@destroy')->name('user.delete');
    Route::get('followings', 'UsersController@followings')->name('user.followings');
    Route::get('followers', 'UsersController@followers')->name('user.followers');
});

// ログイン後
Route::group(['middleware' => 'auth'], function () {
    // 投稿
    Route::prefix('posts')->group(function () {
        Route::post('', 'PostsController@store')->name('post.store');
    });
    // フォロー
    Route::prefix('users/{id}')->group(function () {
        Route::post('follow', 'UsersController@follow')->name('follow');
        Route::delete('unfollow', 'UsersController@unfollow')->name('unfollow');
    });
});