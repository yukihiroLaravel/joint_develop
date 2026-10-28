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

// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/', 'PostsController@index');

// ユーザ詳細
Route::prefix('users')->group(function(){
    Route::get('{id}', 'PostsController@show')->name('users.show');
    Route::get('{id}/followings', 'UserFollowController@followings')->name('users.followings');
    Route::get('{id}/followers', 'UserFollowController@followers')->name('users.followers');
});

// ログイン後
// 投稿編集画面・更新処理
Route::group(['middleware' => 'auth'], function () {
    Route::prefix('posts')->group(function(){
        Route::get('{id}/edit', 'PostsController@edit')->name('post.edit');
        Route::put('{id}', 'PostsController@update')->name('post.update');
        //投稿削除
        Route::delete('{id}', 'PostsController@destroy')->name('post.destroy');
    });

    // ユーザ退会
    Route::delete('users/{id}', 'UsersController@destroy')->name('user.destroy');
    // フォロー・フォロー解除
    Route::post('users/{id}/follow', 'UserFollowController@store')->name('user.follow');
    Route::delete('users/{id}/unfollow', 'UserFollowController@destroy')->name('user.unfollow');
});