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

use App\Http\Controllers\FollowersController;

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
    Route::delete('{id}', 'PostsController@destroy')->name('post.delete');
    //ユーザー編集
    Route::prefix('users/{id}')->group(function () {
        Route::get('edit', 'EditUserController@edit')->name('edit'); 
        Route::put('', 'EditUserController@update')->name('update');
        Route::delete('', 'EditUserController@destroy')->name('user.delete');
    //フォロー機能
        Route::post('follow', 'FollowersController@store')->name('follow');
        Route::delete('unfollow', 'FollowersController@destroy')->name('unfollow');
    });
});
