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


//トップページ
Route::get('/', 'PostsController@index');

// ユーザ新規登録
Route::get('signup','Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup','Auth\RegisterController@register')->name('signup.post');



//ログイン・ログアウト
Route::get('login','Auth\LoginController@showLoginForm')->name('login');
Route::post('login','Auth\LoginController@login')->name('login.post');
Route::get('logout','Auth\LoginController@logout')->name('logout');



// ログイン後
Route::group(['middleware' => 'auth'], function () {
    // 動画
    Route::prefix('posts')->group(function () {
        Route::get('create', 'PostsController@create')->name('post.create');
        Route::post('', 'PostsController@store')->name('post.store');
        Route::delete('{id}', 'PostsController@destroy')->name('post.delete');
    });
        
});