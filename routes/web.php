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

// 投稿
Route::get('/', 'PostsController@index');
// 投稿検索
Route::get('/search', 'SearchController@index')->name('search');
// Route::get('/search', [SearchController::class, 'index'])->name('search');

// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// ログイン後
Route::group(['middleware' => 'auth'], function () {
    // ユーザ
    Route::prefix('users')->group(function () {
        Route::get('{id}', 'UsersController@show')->name('user.show');
        Route::get('{id}/edit', 'UsersController@edit')->name('user.edit');
        Route::put('{id}', 'UsersController@update')->name('user.update');
        Route::delete('{id}', 'UsersController@destroy')->name('user.delete');
    });
    // 投稿・削除
    Route::prefix('post')->group(function () {
        Route::post('/', 'PostsController@store')->name('post.store');
        Route::get('{id}/edit', 'PostsController@edit')->name('post.edit');
        Route::put('{id}', 'PostsController@update')->name('post.update');
        Route::delete('{id}', 'PostsController@destroy')->name('post.delete');
    });
});
