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

// 投稿関連のルート
Route::get('/', 'PostsController@index');

// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

//ユーザ詳細
Route::get('users/{id}', 'UsersController@show')->name('user.show');

// 検索用（検索窓）のルート・ログインは不要
Route::get('/search', 'PostsController@search')->name('posts.search');

// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
// ログイン後
Route::group(['middleware' => 'auth'], function () {

    // 投稿
    Route::prefix('posts')->group(function () {
        Route::post('/', 'PostsController@store')->name('post.store');
        Route::get('{id}/edit', 'PostsController@edit')->name('post.edit');
        Route::put('{id}', 'PostsController@update')->name('post.update');
        Route::delete('{id}', 'PostsController@destroy')->name('post.delete');
    });
    // ユーザ編集・更新・フォロー
    Route::group(['prefix' => 'users'],function(){
        Route::get('{id}/edit', 'UsersController@edit')->name('users.edit');
        Route::put('{id}', 'UsersController@update')->name('users.update');
        Route::post('{id}/follow', 'FollowController@store')->name('follow');
        Route::delete('{id}/unfollow', 'FollowController@destroy')->name('unfollow');

    // 退会処理のルート
        Route::delete('{id}', 'UsersController@destroy')->name('users.destroy');
    });
});