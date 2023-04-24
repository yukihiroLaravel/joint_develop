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
    // 新規登録画面表示
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
    // 新規登録実行
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ユーザ（詳細、編集、更新、削除）
Route::prefix('users/{id}')->group(function () {
    Route::get('/', 'UsersController@show')->name('users.show');
    Route::group(['middleware' => 'auth'], function () {
            Route::get('edit', 'UsersController@edit')->name('users.edit');
            Route::put('/', 'UsersController@update')->name('users.update');
            Route::delete('/', 'UsersController@destroy')->name('users.delete');
            // フォロー機能
            Route::post('follow', 'FollowController@store')->name('follow');
            Route::delete('unFollow', 'FollowController@destroy')->name('unFollow');
    });
});

// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// 投稿一覧表示
Route::get('/', 'PostsController@index')->name('posts');

// 投稿関連
Route::group(['middleware' => 'auth'], function () {
    // 投稿（新規、編集、更新、削除）
    Route::prefix('posts')->group(function () {
        Route::delete('{id}', 'PostsController@destroy')->name('post.delete');
    });
});
