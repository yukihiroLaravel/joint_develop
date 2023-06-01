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
// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// ユーザ
Route::prefix('users')->group(function () {
    Route::get('{id}', 'UsersController@show')->name('user.show');
    // フォロー機能（ログイン後）
    Route::post('{id}', 'FollowController@store')->name('follow');
    Route::delete('{id}/unFollow', 'FollowController@destroy')->name('unFollow');
});

Route::get('/', function () {
    return view('welcome');
});
// トップページ
Route::get('/', 'postsController@index');

// ログイン後
Route::group(['middleware' => 'auth'], function () {
    // 投稿新規作成（投降削除はこれから実装予定）
    Route::prefix('posts')->group(function () {
        Route::post('', 'PostsController@store')->name('post.store');
        Route::delete('{id}', 'PostsController@destroy')->name('post.delete');
    });
});