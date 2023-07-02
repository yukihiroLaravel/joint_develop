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

use App\Http\Controllers\FollowersController;

Route::get('/', 'PostsController@index');
// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ユーザ詳細ページ
Route::prefix('users')->group(function () {
    Route::get('{id}', 'UsersController@show')->name('user.show');
    Route::get('{id}/followingList', 'UsersController@showFollowingList')->name('user.followingList');
    Route::get('{id}/followedList', 'UsersController@showFollowedList')->name('user.followedList');
    // あとで
});

// 検索機能
Route::get('', 'PostsController@search')->name('search');

// ログイン後
Route::group(['middleware' => 'auth'], function () {
    // 投稿
    Route::post('posts', 'PostsController@store')->name('post.store');
    Route::delete('{id}', 'PostsController@destroy')->name('post.delete');
    // コメント
    Route::prefix('comments')->group(function () {
        Route::post('', 'CommentsController@store')->name('comment.store');
        Route::delete('{id}', 'CommentsController@destroy')->name('comment.delete');
    });
    //ユーザー編集
    Route::prefix('users/{id}')->group(function () {
        Route::get('edit', 'UsersController@edit')->name('edit'); 
        Route::put('', 'UsersController@update')->name('update');
        Route::delete('', 'UsersController@destroy')->name('user.delete');
    //フォロー機能
        Route::post('follow', 'FollowersController@store')->name('follow');
        Route::delete('unfollow', 'FollowersController@destroy')->name('unfollow');
    });
    // いいね
    Route::prefix('posts/{id}')->group(function () {
        Route::post('favoritePost', 'FavoriteController@storePost')->name('favorite.post');
        Route::delete('unfavoritePost', 'FavoriteController@destroyPost')->name('unfavorite.post');
    });
    // Route::prefix(['comments/{id}'], function(){
    //     Route::post('favoriteComment', 'FavoriteController@storeComment')->name('favorite.comment');
    //     Route::delete('unfavoriteComment', 'FavoriteController@destroyComment')->name('unfavorite.comment');
    // });
});
