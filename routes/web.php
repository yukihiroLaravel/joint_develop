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
// トップページの表示
Route::get('/', 'PostsController@index');

// ログイン後
Route::group(['middleware' => 'auth'], function () {
    // 動画
    Route::prefix('posts')->group(function () {
        Route::post('', 'PostsController@store')->name('post.store');
    });
});


Route::prefix('users')->middleware('auth')->group(function () {

    //ユーザ編集・更新
    Route::get('{id}/edit', 'UsersController@edit')->name('user.edit');
    Route::put('{id}', 'UsersController@update')->name('user.update');
    
    // ユーザ詳細・フォロー
    Route::post('{id}/follow', 'FollowController@follow')->name('user.follow');
    Route::delete('{id}/unfollow', 'FollowController@unfollow')->name('user.unfollow');

    Route::get('{id}', 'PostsController@show')->name('user.show');
    Route::delete('{id}', 'PostsController@destroy')->name('user.delete');
});

// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ログイン、ログアウト
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');