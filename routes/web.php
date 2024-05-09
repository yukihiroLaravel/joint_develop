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
// トップページの投稿表示
Route::get('/', 'PostsController@index')->name('top');
// ユーザー　ログイン・ログアウト
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// 投稿新規作成
Route::group(['prefix' => 'posts', 'middleware' => 'auth'], function () {
    Route::post('/', 'PostsController@store')->name('posts.store');
    Route::get('{id}/edit', 'PostsController@edit')->name('posts.edit');
    Route::patch('{id}/update', 'PostsController@update')->name('posts.update');
    // フォロー機能
    Route::post('/follow/{id}', 'FollowController@store')->name('follow.store');
    Route::delete('/unfollow/{id}', 'FollowController@destroy')->name('follow.destroy');
});
 //　ログイン後
Route::group(['middleware' => 'auth'], function () {
    //　ユーザ退会・更新
     Route::prefix('users')->group(function () {
     Route::delete('/users{id}', 'UsersController@destroy')->name('users.delete'); //ユーザ削除
     Route::get('/users/{id}', 'UsersController@edit')->name('users.edit'); //ユーザ退会用で作成
     Route::put('{id}', 'UsersController@update')->name('users.update'); //ユーザ退会用で作成
    });
});
// ユーザ詳細
Route::get('/users/{id}', 'UsersController@show')->name('users.show');
