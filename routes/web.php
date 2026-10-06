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
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

Route::get('/', 'PostsController@index');

//ユーザ詳細
Route::prefix('users')->group(function(){
    Route::get('{id}', 'PostsController@show')->name('users.show');
});

//ログイン後
//投稿編集画面・更新処理
Route::group(['middleware' => 'auth'], function () {
    Route::prefix('posts')->group(function(){
        Route::get('{id}/edit', 'PostsController@edit')->name('post.edit');
        Route::put('{id}', 'PostsController@update')->name('post.update');
    });
});