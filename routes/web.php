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

// ユーザ詳細
Route::get('users/{id}', 'UsersController@show')->name('users.show');

// ログイン後機能  ※ログイン機能完成後に有効化
// Route::group(['middleware' => 'auth'], function () {
// 新規投稿
Route::post('posts', 'PostsController@store')->name('posts.store');
// 投稿削除
Route::delete('posts/{id}', 'PostsController@destroy')->name('post.delete');
// リアクション
Route::post('posts/{id}/reaction', 'ReactionsController@toggle')->name('reaction.toggle');

Route::prefix('users')->group(function () {
    // ユーザ編集・更新
    Route::get('{id}/edit', 'UsersController@edit')->name('users.edit');
    Route::put('{id}', 'UsersController@update')->name('users.update');
    // ユーザ退会
    Route::delete('{id}', 'UsersController@destroy')->name('users.destroy');
    // ユーザーのフォロー
    Route::post('users/{id}', 'FollowController@store')->name('users.follow');
    // ユーザーのフォロー解除
Route::delete('users/{id}', 'FollowController@destroy')->name('users.unfollow');
});
// });

// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');
