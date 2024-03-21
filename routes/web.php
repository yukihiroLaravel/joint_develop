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

//投稿一覧
Route::get('/', 'PostsController@index');

// ユーザー新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

Route::prefix('users/{id}')->group(function () {
    Route::get('', 'UserController@show')->name('user.show');
    Route::get('follow', 'UserController@followUsersShow')->name('users.follow');
    Route::get('follower', 'UserController@followerUsersShow')->name('users.follower');
});

//ログイン
Route::get('login', 'Auth\LoginController@showLoginform')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// ログイン後
Route::group(['middleware' => 'auth'], function () {
    Route::prefix('users/{id}')->group(function () {
        Route::get('edit', 'UserController@edit')->name('users.edit');
        Route::put('', 'UserController@update')->name('users.update');
        Route::delete('', 'UserController@destroy')->name('user.delete');
        Route::post('follow', 'FollowController@store')->name('follow');
        Route::delete('unfollow', 'FollowController@destroy')->name('unfollow');
    });
    Route::post('posts', 'PostsController@store')->name('post.store');
    Route::delete('post/{id}', 'PostsController@destroy')->name('post.delete');
    //コメント機能、編集、更新、削除
    Route::prefix('comments/{id}')->group(function () {
        Route::post('', 'CommentsController@store')->name('comments.store');
        Route::get('create', 'CommentsController@create')->name('comments.create');
        Route::get('{id}/edit', 'CommentsController@edit')->name('comments.edit');        
        Route::put('{id}/', 'CommentsController@update')->name('comments.update');
        Route::delete('{id}', 'CommentsController@destroy')->name('comments.delete');
    });
});