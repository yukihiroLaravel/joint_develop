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
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// ログイン後
Route::group(['middleware' => 'auth'], function () {
   // ユーザ編集、更新、退会
   Route::prefix('users/{id}')->group(function () {
       Route::get('edit', 'UsersController@edit')->name('user.edit');
       Route::put('', 'UsersController@update')->name('user.update');
       Route::delete('', 'UsersController@destroy')->name('user.delete');
   });
   // 新規投稿、編集(なりさん担当)、更新(なりさん担当)、削除(清水さん担当)
   Route::prefix('posts')->group(function () {
       Route::post('', 'PostsController@store')->name('posts.store'); 
       Route::delete('posts/{id}', 'PostsController@destroy')->name('posts.delete');
   });
});