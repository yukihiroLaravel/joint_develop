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

// ユーザ情報編集
    Route::prefix('user')->group(function () {
        Route::get('{id}/edit', 'UsersController@edit')->name('user.edit');
        Route::post('{id}/edit', 'UsersController@update')->name('user.update');
    });

Route::get('/', 'UsersController@index');
