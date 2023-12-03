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

// ユーザ編集(ログインユーザのみ)＆ユーザー退会
Route::group(['middleware' => 'auth'], function(){
    Route::prefix('users')->group(function() {
        Route::get('{id}/edit', 'UsersController@edit')->name('user.edit');
        Route::put('{id}', 'UsersController@update')->name('user.update');
        Route::delete('{id}', 'UsersController@destroy')->name('user.delete');
    });
});

//トップページ表示
Route::get('/', 'PostsController@index');
