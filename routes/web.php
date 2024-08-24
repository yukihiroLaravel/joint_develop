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

Route::get('/', function () {
    return view('welcome');
});

// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post'); 

// ユーザ
Route::group(['prefix' => 'users/{id}'],function(){

    // *******************
    // ユーザ詳細
    // *******************
    // タイムライン
    Route::get('', 'UsersController@show')->name('user.show');
    // フォロー中
    Route::get('followings','UsersController@followings')->name('user.followings');
    // フォロワー
    Route::get('followers','UsersController@followers')->name('user.followers');
    // *******************
});

// ログイン後
Route::group(['middleware' => 'auth'], function() {
    // 「投稿」
    Route::prefix('posts')->group(function(){
        // 登録
        Route::post('', 'PostsController@store')->name('post.store');
    });
});
