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

Route::get('/', 'PostsController@index')->name('post.index');

// ユーザ
Route::group(['prefix' => 'users/{id}'],function () {
    Route::get('/', 'UsersController@show')->name('user.show');
    Route::get('followings','UsersController@followings')->name('followings');
    Route::get('followers','UsersController@followers')->name('followers');
});

// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

//ログイン後
Route::group(['middleware' => 'auth'], function() {
    //投稿
    Route::prefix('posts')->group( function () {
        Route::post('', 'PostsController@store')->name('posts.store');
        Route::delete('{id}', 'PostsController@destroy')->name('posts.delete');
        Route::get('{id}/edit', 'PostsController@edit')->name('post.edit');
        Route::put('{id}', 'PostsController@update')->name('post.update');
    });
 
    //フォロー
    Route::group(['prefix' => 'users/{id}'],function() {
        Route::post('follow','FollowController@store')->name('follow');
        Route::delete('unfollow','FollowController@destroy')->name('unfollow');
    });
    
    // ユーザ編集・退会
    Route::prefix('users')->group( function () {
        Route::get('{id}/edit', 'UsersController@edit')->name('user.edit');
        Route::put('{id}', 'UsersController@update')->name('user.update');
        Route::delete('{id}', 'UsersController@destroy')->name('user.delete');
    });
});