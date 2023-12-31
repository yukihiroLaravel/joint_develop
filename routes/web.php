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

// トップページ表示
Route::get('/', 'PostsController@index')->name('post.index');

// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

//ユーザー詳細
Route::group(['prefix' => 'users/{id}'],function(){
    Route::get('', 'UsersController@show')->name('user.show');
    Route::get('followings','UsersController@followings')->name('user.followings');
    Route::get('followers','UsersController@followers')->name('user.followers');
});

// ユーザ編集(ログインユーザのみ)＆ユーザー退会
// ログイン後
Route::group(['middleware' => 'auth'], function(){
    // ユーザ
    Route::prefix('users')->group(function() {
        Route::get('{id}/edit', 'UsersController@edit')->name('user.edit');
        Route::put('{id}', 'UsersController@update')->name('user.update');
        Route::delete('{id}', 'UsersController@destroy')->name('user.delete');
    });
    // 投稿
    Route::prefix('posts')->group(function() {
        // 削除
        Route::delete('{id}','PostsController@destroy')->name('post.delete');
        // 投稿編集
        Route::get('{id}/edit', 'PostsController@edit')->name('post.edit');
        // 投稿更新
        Route::put('{id}', 'PostsController@update')->name('post.update');
        //新規投稿作成
        Route::post('/', 'PostsController@store')->name('createPost');

      });
});
    //フォロー機能
    Route::group(['prefix' => 'users/{id}'],function(){
        Route::post('follow','FollowController@store')->name('follow');
        Route::delete('unfollow','FollowController@destroy')->name('unfollow');
    });