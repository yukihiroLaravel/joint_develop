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

//ユーザー詳細
Route::get('users/{id}','UsersController@show')->name('user.show');   
 

// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// トップページ表示
Route::get('/', 'PostsController@index');
//ユーザー詳細
Route::prefix('users/{id}')->group(function(){
    Route::get('','UsersController@show')->name('user.show');
    Route::group(['middleware' => 'auth'], function () {
        Route::post('follow','FollowController@store')->name('follow');
        Route::post('unfollow','FollowController@destroy')->name('unfollow');
    });
});

// ログイン後
Route::group(['middleware' => 'auth'], function () {
    Route::prefix('posts')->group(function () {
        //新規投稿
        Route::post('', 'PostsController@store')->name('post.store');
        //投稿削除
        Route::delete('{id}', 'PostsController@destroy')->name('post.delete');
        //投稿編集
        Route::get('{id}/edit', 'PostsController@edit')->name('post.edit');
        //投稿更新
        Route::put('{id}', 'PostsController@update')->name('post.update');
    });
    Route::prefix('users/{id}')->group(function(){
        //編集
        Route::get('edit', 'UsersController@edit')->name('user.edit');
        //更新
        Route::put('', 'UsersController@update')->name('user.update');
        //削除
        Route::delete('', 'UsersController@destroy')->name('user.delete');
    });
});


