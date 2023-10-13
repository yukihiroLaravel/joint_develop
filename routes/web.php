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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'UsersController@index');

// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

//ログインユーザのみ
Route::group(['middleware' => 'auth'], function () {
    Route::prefix('users')->group(function () {
        //ユーザ編集画面
        Route::get('{id}/edit', 'UsersController@edit')->name('users.edit');
        //ユーザ編集処理        
        Route::put('{id}', 'UsersController@update')->name('users.update');
    });

    //フォロー、フォロワー
    Route::group(['prefix' => 'users/{id}'],function(){
        Route::post('follow','FollowController@store')->name('follow');
        Route::delete('unfollow','FollowController@destroy')->name('unfollow');
    });
});

    
//ログイン
Route::get('login','Auth\LoginController@showLoginForm')->name('login');
Route::post('login','Auth\LoginController@login')->name('login.post');
Route::get('logout','Auth\LoginController@logout')->name('logout');



