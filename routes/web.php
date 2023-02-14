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
// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

//ログイン時のみ
Route::group(['middleware'=>'auth'], function () {
    Route::group(['prefix'=>'users'], function () {
        Route::get('{id}/edit', 'UsersController@edit')->name('user.edit');
        Route::put('{id}', 'UsersController@update')->name('user.update');
        Route::delete('{id}', 'UsersController@destroy')->name('user.delete');
    });
    //投稿編集・更新
    Route::group(['prefix'=>'post'],function(){
        Route::get('{id}/edit','PostsController@edit')->name('post.edit');
        Route::put('{id}','PostsController@update')->name('post.update');
    });
});
//新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

//投稿一覧表示
Route::get('/', 'PostsController@index');

//ユーザ
Route::group(['prefix'=>'users'], function () {
    Route::get('{id}', 'UsersController@show')->name('user.show');
});
