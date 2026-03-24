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

Route::get('/', 'PostsController@index');

// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');
// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// ログイン後のみ可能な操作
Route::group(['middleware' => 'auth'], function () {
    Route::delete('post/{id}', 'PostsController@destroy')->name('post.destroy');
    
    // ユーザ情報_編集画面表示 
    Route::get('users/{id}/edit', 'UsersController@edit')->name('user.edit');
    // ユーザ情報_更新 
    Route::put('users/{id}', 'UsersController@update')->name('user.update');
    // いいね
    Route::group(['prefix' => 'posts/{id}'],function(){
        Route::post('favorite','FavoriteController@store')->name('favorite');
        Route::delete('unfavorite','FavoriteController@destroy')->name('unfavorite');
    });
});

// ユーザ一覧と詳細・お気に入り
Route::get('users', 'UsersController@index')->name('users'); 

Route::group(['prefix' => 'users/{id}'],function(){
    Route::get('', 'UsersController@show')->name('user.show');
    Route::get('favorites','UsersController@favorites')->name('user.favorites');
});

Route::post('posts', 'PostsController@store')->name('posts.store');
Route::get('posts/{id}/favorites', 'PostsController@favorites')->name('post.favorites');
