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

// 投稿一覧
Route::get('/', 'PostsController@index')->name('posts');
// 新規投稿
Route::post('posts', 'PostsController@store')->name('posts.store');

// ログイン機能完成後に有効化
// Route::group(['middleware' => 'auth'], function () {
Route::prefix('users')->group(function () {
    // ユーザ詳細
    Route::get('{id}', 'UsersController@show')->name('users.show');
    // ユーザ編集・更新
    Route::get('{id}/edit', 'UsersController@edit')->name('users.edit');
    Route::put('{id}', 'UsersController@update')->name('users.update');
});
// });

// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');