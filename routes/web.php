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
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');
// ログイン(user_edit開発中の検証のため一時的に追加)
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
// ログアウト(user_edit開発中の検証のため一時的に追加)
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::delete('post/{id}', 'PostsController@destroy')->name('post.destroy');
});
//ユーザ詳細
// http://localhost:8080/users/{id} でユーザ詳細表示
Route::prefix('users')->group(function () {
    Route::get('{id}', 'UsersController@show')->name('user.show');
    // （user_edit）ユーザ情報_編集画面表示（get）  
    // http://localhost:8080/users/{id}/edit でユーザ編集画面表示
    Route::get('{id}/edit', 'UsersController@edit')->name('user.edit');
    // （user_edit）ユーザ情報_更新（put） 
    // http://localhost:8080/users/{id} でユーザ編集更新
    Route::put('{id}', 'UsersController@update')->name('user.update');
});
