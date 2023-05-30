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
// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ユーザ詳細ページ
Route::prefix('users')->group(function () {
    Route::get('{id}', 'UsersController@show')->name('user.show');
});
// ログイン後
Route::group(['middleware' => 'auth'], function () {
    // 投稿
    Route::post('posts', 'PostsController@store')->name('post.store');
    //ユーザー編集
    Route::prefix('users')->group(function () {
        Route::get('{id}/edit', 'EditUserController@edit')->name('edit'); 
        Route::put('{id}', 'EditUserController@update')->name('update');
        Route::delete('{id}', 'EditUserController@destroy')->name('user.delete');
    });
});
