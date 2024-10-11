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
Route::get('/', 'PostsController@index')->name('welcome');

// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

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
        //削除
        Route::delete('{id}', 'PostsController@destroy')->name('post.delete');
        //投稿編集・更新
        Route::get('{id}/edit', 'PostsController@edit')->name('post.edit');
        Route::put('{id}', 'PostsController@update')->name('post.update');

        // 返信画面を表示するルート
        Route::get('{post}/reply', 'PostsController@showReplyForm')->name('posts.reply_form');

        // 投稿への返信を処理するルート
        Route::post('{post}/reply', 'PostsController@reply')->name('posts.reply');

        //返信削除
        Route::delete('reply/{reply}', 'PostsController@deleteReply')->name('reply.delete');
    });

    Route::prefix('users/{id}')->group(function () {
        // フォロー
        Route::post('follow', 'UsersController@follow')->name('follow');
        Route::delete('unfollow', 'UsersController@unfollow')->name('unfollow');
        
        // ユーザー編集・更新
        Route::get('edit', 'UsersController@edit')->name('user.edit');
        Route::put('', 'UsersController@update')->name('user.update');
    });

});