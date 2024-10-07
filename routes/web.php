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

//ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// ユーザ
// Route::get('/', 'UsersController@index')->name('user.index');
Route::prefix('users/{id}')->group(function() {
    // ユーザ詳細
    Route::get('', 'UsersController@show')->name('user.show');
    // フォロー中・フォロワーのタブ
    Route::get('timelineFollowing', 'UsersController@timelineFollowing')->name('timelineFollowing');
    Route::get('timelineFollowers', 'UsersController@timelineFollowers')->name('timelineFollowers');
});

// 最初のページ・投稿の検索機能
Route::get('/', 'PostsController@index')->name('index');

// ログイン後
Route::group(['middleware' => 'auth'], function() {
    // 投稿
    Route::prefix('posts')->group(function() {
        Route::post('', 'PostsController@store')->name('post.store');
        Route::get('{id}/edit', 'PostsController@edit')->name('post.edit');
        Route::put('{id}', 'PostsController@update')->name('post.update');
        Route::delete('{id}', 'PostsController@destroy')->name('post.delete');
    });
    Route::prefix('users/{id}')->group(function() {
        // ユーザの編集・更新・削除
        Route::get('edit', 'UsersController@edit')->name('user.edit');
        Route::put('', 'UsersController@update')->name('user.update');
        Route::delete('delete', 'UsersController@destroy')->name('user.delete');
        // ユーザーをフォロー・アンフォロー
        Route::post('follow', 'FollowController@store')->name('follow');
        Route::delete('unfollow', 'FollowController@destroy')->name('unfollow');
    });
});