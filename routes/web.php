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

Route::get('/', 'PostsController@index');

// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ログイン後のみ可能な操作
Route::group(['middleware' => 'auth'], function () {
    Route::post('post', 'PostsController@store')->name('post.store');
    Route::put('post/{id}', 'PostsController@update')->name('post.update');
    Route::delete('post/{id}', 'PostsController@destroy')->name('post.destroy');
});
