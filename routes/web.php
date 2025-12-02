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

// ログイン後
Route::group(['middleware' => 'auth'], function () {
    
        Route::post('posts/store', 'PostsController@store')->name('post.store');
        Route::delete('posts/{id}', 'PostsController@destroy')->name('post.delete');
        Route::get('messages/{id}/edit', 'PostsController@edit')->name('post.edit');
    });
// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');