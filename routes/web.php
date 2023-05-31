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

// ログイン後
 
Route::get('users/{id}/edit', 'UsersController@edit')->name('user.edit');
Route::put('users/{id}', 'UsersController@update')->name('user.update');

// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');


    



// トップページ表示
Route::get('/', 'PostsController@index');


// ログイン後
Route::group(['middleware' => 'auth'], function () {
    Route::prefix('posts')->group(function () {
        //新規投稿
        Route::post('', 'PostsController@store')->name('post.store');
        //投稿削除
        Route::delete('{id}', 'PostsController@destroy')->name('post.delete');
    });
});
