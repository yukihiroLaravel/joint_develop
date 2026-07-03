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

// トップページ
Route::get('/', 'PostsController@index');
// ユーザ新規登録画面を表示
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');

// ユーザ新規登録処理
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ログイン、ログアウト
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::prefix('users')->group(function () {
    // ユーザ詳細画面を表示
    Route::get('{id}', 'UsersController@show')->name('user.show');
    // フォロー中一覧
    Route::get('{id}/followings', 'UsersController@followings')->name('user.followings');
    // フォロワー一覧
    Route::get('{id}/followers', 'UsersController@followers')->name('user.followers');
    // フォロー実行
    Route::post('{id}/follow', 'FollowsController@store')->name('user.follow')->middleware('auth');
    // フォロー解除
    Route::delete('{id}/unfollow', 'FollowsController@destroy')->name('user.unfollow')->middleware('auth');
    // ユーザ退会処理
    Route::delete('{id}', 'UsersController@destroy')->name('user.destroy')->middleware('auth');
});

// 投稿
Route::prefix('posts')->middleware('auth')->group(function () {
    Route::get('{id}/edit', 'PostsController@edit')->name('post.edit');
    Route::put('{id}', 'PostsController@update')->name('post.update');
});