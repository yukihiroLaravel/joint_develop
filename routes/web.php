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

// ログイン、ログアウト
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

//トップページ投稿表示
Route::get('/', 'PostsController@index');

// ログイン後
Route::group(['middleware' => 'auth'], function (){
  Route::prefix('posts')->group(function () {
      Route::get('{id}/edit', 'PostsController@edit')->name('post.edit');
      Route::put('{id}', 'PostsController@update')->name('post.update');
  });
});

//Route::get('/', 'UsersController@index');
