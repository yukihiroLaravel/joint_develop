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

//トップページ表示
Route::get('/', 'PostsController@index')->name('posts.index');


// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');
// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// ユーザ
Route::prefix('users')->group(function () {
    Route::get('{id}', 'UsersController@show')->name('users.show');
});

// ユーザー編集・更新
Route::group(['middleware' => 'auth'], function () {
    Route::prefix('users')->group(function () {
        Route::get('{id}/edit', 'UsersController@edit')->name('users.edit');
        Route::put('{id}', 'UsersController@update')->name('users.update');
        Route::delete('{id}', 'UsersController@destroy')->name('users.delete');
    });
    //新規投稿
    Route::prefix('posts')->group(function () {    
        Route::post('', 'PostsController@store')->name('posts.store');
    });

    // 投稿編集・更新
    Route::prefix('posts')->group(function () {  
        Route::get('{id}/edit', 'PostsController@edit')->name('posts.edit');
        Route::put('{id}', 'PostsController@update')->name('posts.update');
    });
    
    //投稿削除
    Route::prefix('posts')->group(function () {    
        Route::delete('{id}', 'PostsController@destroy')->name('posts.delete');
    });
    //フォロー
    Route::group(['prefix' => 'users/{id}'],function(){
        Route::post('follows','FollowController@store')->name('follow');
        Route::delete('unfollow','FollowController@destroy')->name('unfollow');
    });
});
