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
//top page 表示
Route::get('/', 'PostsController@index')->name('posts.index');
//ユーザー情報関連

Route::prefix('users')->group(function () {
    Route::get('{id}', 'UsersController@show')->name('user.show');
    Route::get('{id}/edit', 'UsersController@edit')->name('user.edit');
    Route::put('{id}/', 'UsersController@update')->name('user.update');
    Route::delete('{id}', 'UsersController@destroy')->name('user.delete');
});
