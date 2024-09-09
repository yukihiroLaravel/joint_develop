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

// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// ユーザ
Route::group(['prefix' => 'users/{id}'],function(){

    // *******************
    // ユーザ詳細
    // *******************
    // タイムライン
    Route::get('', 'UsersController@show')->name('user.show');
    // フォロー中
    Route::get('followings','UsersController@followings')->name('user.followings');
    // フォロワー
    Route::get('followers','UsersController@followers')->name('user.followers');
    // *******************
});

// ログイン後
Route::group(['middleware' => 'auth'], function() {
    // 「ユーザ」
    Route::prefix('users')->group(function(){
        // 削除
        Route::delete('{id}', 'UsersController@destroy')->name('user.delete');
        //編集・更新
        Route::get('{id}/edit', 'UsersController@edit')->name('user.edit');
        Route::put('{id}', 'UsersController@update')->name('user.update');
    });
    
    // 「投稿」
    Route::prefix('posts')->group(function(){
        // 登録
        Route::post('', 'PostsController@store')->name('post.store');
    });

    // 「フォロー」
    Route::group(['prefix' => 'follows/{id}'],function(){
        Route::post('follow', 'FollowsController@store')->name('follow');
        Route::delete('unfollow', 'FollowsController@destroy')->name('unfollow');
    });
});
