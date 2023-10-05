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

// ユーザ編集
Route::group(['middleware' => 'auth'], function () {
    Route::prefix('users/{id}')->group(function () {
        Route::get('', 'UsersController@edit')->name('users.edit');
        Route::put('', 'UsersController@update')->name('users.update');
    });
});
