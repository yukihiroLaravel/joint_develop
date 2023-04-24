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
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
//トップページ
Route::get('/', 'PostController@index');
//ユーザー詳細、編集、更新
Route::prefix('users')->group(function () {
    Route::get('{id}', 'UsersController@show')->name('users.show');
    Route::get('{id}/edit', 'UsersController@edit')->name('users.edit');
    Route::put('{id}', 'UsersController@update')->name('users.update');
});
//ユーザ登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ログイン後
Route::group(['middleware' => 'auth'], function () {
  // 投稿
Route::prefix('post')->group(function () {
    Route::post('', 'PostController@store')->name('post.store');
    Route::delete('{id}', 'PostController@destroy')->name('post.delete');
    Route::get('{id}/edit', 'PostController@edit')->name('post.edit');
    Route::put('{id}', 'PostController@update')->name('post.update');
  });
  // いいね
  Route::group(['prefix' => 'users/{id}'],function(){
      Route::post('follow','FollowController@store')->name('follow');
      Route::delete('unFollow','FollowController@destroy')->name('unFollow');
  });
});
