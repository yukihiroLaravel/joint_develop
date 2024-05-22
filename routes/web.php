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

// トップページの投稿表示、検索フォーム表示
Route::get('/', 'PostsController@index')->name('top');

// ユーザー　ログイン・ログアウト
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// 投稿
Route::group(['prefix' => 'posts', 'middleware' => 'auth'], function () {
    Route::post('/', 'PostsController@store')->name('posts.store');
    Route::get('{id}/edit', 'PostsController@edit')->name('posts.edit');
    Route::patch('{id}/update', 'PostsController@update')->name('posts.update');
    Route::delete('/{id}', 'PostsController@destroy')->name('posts.destroy');
    // フォロー機能
    Route::post('/follow/{id}', 'FollowController@store')->name('follow.store');
    Route::delete('/unfollow/{id}', 'FollowController@destroy')->name('unfollow.destroy');
});

// ユーザ詳細
Route::group(['prefix' => 'users/{id}'],function(){
    Route::get('/', 'UsersController@show')->name('users.show');
    //フォロー、フォロワー投稿表示
    Route::get('followings','UsersController@followings')->name('followings');
    Route::get('followers','UsersController@followers')->name('followers');
});

// ユーザ編集画面・更新(ログインユーザのみ、prefixでグループ化)
Route::group(['middleware' => 'auth'], function(){
    Route::prefix('users')->group(function() {
        Route::get('{id}/edit', 'UsersController@edit')->name('users.edit');
        Route::put('{id}', 'UsersController@update')->name('users.update');
    });
});
