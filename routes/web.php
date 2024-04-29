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
// トップページの投稿表示
Route::get('/', 'PostsController@index');

// 投稿新規作成
Route::group(['middleware'=>'auth'], function () {
  Route::post('posts', 'PostsController@store')->name('posts.store');
});