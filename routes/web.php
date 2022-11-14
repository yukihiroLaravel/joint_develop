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

//ユーザ新規登録
Route::get('signup','Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup','Auth\RegisterController@register')->name('signup.post');

//トップページ
Route::get('/', 'PostsController@index')->name('home');

//ログイン、ログアウト
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');


Route::prefix('users')->group(function () {
    //ユーザー詳細
    Route::get('{id}', 'UsersController@show')->name('user.show');
    //ユーザー編集
    Route::get('{id}/edit', 'UsersController@edit')->name('users.edit');
    Route::put('{id}', 'UsersController@update')->name('users.update');
    //ユーザー退会
    Route::post('{id}/delete', 'UsersController@delete')->name('users.delete');
});

// ログイン後
Route::group(['middleware' => 'auth'], function () {
    Route::prefix('posts')->group(function () {
        //新規投稿機能
        Route::post('', 'PostsController@store')->name('post.store');
        //投稿編集画面の表示
        Route::get('edit/{id}','PostsController@showEdit')->name('post.edit');
        //投稿編集機能
        Route::put('{id}','PostsController@update')->name('post.update');
        //投稿削除機能
        Route::delete('{id}', 'PostsController@destroy')->name('post.delete');
    });
});

