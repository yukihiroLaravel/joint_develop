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
// トップページの投稿表示
Route::get('/', 'PostsController@index');
// ユーザー　ログイン・ログアウト
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
// 投稿新規作成
Route::group(['middleware'=>'auth'], function () {
    Route::post('posts', 'PostsController@store')->name('posts.store');
    // フォロー機能
    Route::post('/follow/{id}', 'FollowController@store')->name('follow.store');
    Route::delete('/unfollow/{id}', 'FollowController@destroy')->name('follow.destroy');
});
// ユーザ詳細
Route::get('/users/{id}', 'UserController@show')->name('users.show');


