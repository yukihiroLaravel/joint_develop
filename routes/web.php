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

// ユーザ
Route::get('/', 'UsersController@index');

Route::prefix('users')->group(function () {
    // ユーザ詳細画面を表示
    Route::get('{id}', 'UsersController@show')->name('user.show');
});

// ユーザ新規登録画面を表示
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');

// ユーザ新規登録処理
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// 投稿
Route::prefix('posts')->middleware('auth')->group(function () {
    Route::get('{id}/edit', 'PostsController@edit')->name('post.edit');
    Route::put('{id}', 'PostsController@update')->name('post.update');
});
