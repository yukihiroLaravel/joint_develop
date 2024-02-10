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

// ユーザー新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ログイン後
Route::group(['middleware' => 'auth'], function () {
  Route::prefix('user')->group(function () {
    Route::get('edit', 'UserController@edit')->name('user.edit');
    Route::put('edit', 'UserController@update')->name('user.update');
  });

  Route::post('/', 'PostsController@store')->name('post.create');
});
