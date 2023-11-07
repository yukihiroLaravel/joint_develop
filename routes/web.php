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

//トップページ（投稿一覧表示）
Route::get('/', 'PostsController@index');

// 検索
Route::prefix('search')->group(function () {
    // 投稿検索
    Route::get('', 'SearchController@postsSearch')->name('posts.search');
});

// ユーザー詳細
Route::prefix('users')->group(function () {
    Route::prefix('{id}')->group(function () {
        Route::get('/', 'UsersController@show')->name('users.show');
        Route::get('followers', 'UsersController@followers')->name('followers');
        Route::get('followings', 'UsersController@followings')->name('followings');
    });
});

//ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

//ログイン・ログアウト
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// ログイン後
Route::group(['middleware' => 'auth'], function () {
    // 新規投稿・投稿編集
    Route::prefix('posts')->group(function () {
        Route::post('', 'PostsController@store')->name('post.store');
        Route::get('{id}/edit', 'PostsController@edit')->name('post.edit');
        Route::put('{id}', 'PostsController@update')->name('post.update');
        Route::delete('{id}', 'PostsController@destroy')->name('post.delete');
    });
    // ユーザー編集・更新、フォロー・アンフォロー
    Route::prefix('users/{id}')->group(function(){
        Route::get('edit', 'UsersController@edit')->name('users.edit');
        Route::put('update', 'UsersController@update')->name('users.update');
        Route::post('follow', 'FollowController@store')->name('follow');
        Route::delete('unfollow', 'FollowController@destroy')->name('unfollow');
        
    });
});