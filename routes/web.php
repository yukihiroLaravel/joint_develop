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

//ユーザー
Route::get('/', 'PostsController@index');
Route::prefix('users')->group(function () {
    Route::get('{id}', 'UsersController@show')->name('user.show');
});

//トップページ（投稿一覧表示）
Route::get('/', 'PostsController@index');

// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

//フォロー、フォロワー
Route::group(['prefix' => 'users/{id}'],function(){
    Route::get('followings','UsersController@followings')->name('followings');
    Route::get('followers','UsersController@followers')->name('followers');
});


//ログインユーザのみ
Route::group(['middleware' => 'auth'], function () {
    Route::prefix('users/{id}')->group(function () {
        //ユーザ編集画面
        Route::get('edit', 'UsersController@edit')->name('users.edit');
        //ユーザ編集処理        
        Route::put('', 'UsersController@update')->name('users.update');
        //ユーザ退会処理
        Route::delete('', 'UsersController@destroy')->name('users.delete');
        Route::post('follow','FollowController@store')->name('follow');
        Route::delete('unfollow','FollowController@destroy')->name('unfollow');
    });

    //投稿新規登録
    Route::prefix('posts')->group(function () {
        Route::post('', 'PostsController@store')->name('post.store');
        //投稿編集
        Route::get('{id}/edit', 'PostsController@edit')->name('posts.edit');
        Route::put('{id}', 'PostsController@update')->name('posts.update');
    
       //投稿削除
        Route::delete('{id}/destroy', 'PostsController@destroy')->name('post.delete');
    });
});

//ログイン
Route::get('login','Auth\LoginController@showLoginForm')->name('login');
Route::post('login','Auth\LoginController@login')->name('login.post');
Route::get('logout','Auth\LoginController@logout')->name('logout');



