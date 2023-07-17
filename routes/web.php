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

// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// トップページ表示
Route::get('/', 'PostsController@index');
//検索機能
Route::get('post/search','PostsController@search')->name('posts.search');
//ユーザー詳細
Route::prefix('users/{id}')->group(function(){
    Route::get('','UsersController@show')->name('user.show');
    Route::get('followingList','UsersController@showFollowingList')->name('user.following');
    Route::get('followerList','UsersController@showFollowerList')->name('user.follower');
    Route::group(['middleware' => 'auth'], function () {
        //ユーザー編集・更新・削除
        Route::get('edit', 'UsersController@edit')->name('user.edit');
        Route::put('', 'UsersController@update')->name('user.update');
        Route::delete('', 'UsersController@destroy')->name('user.delete');
        //フォロー機能
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
    Route::prefix('comments')->group(function () {
        Route::post('', 'CommentsController@store')->name('comment.store');
        Route::delete('{id}', 'CommentsController@destroy')->name('comment.delete');
    });
      // 動画
      Route::prefix('movies')->group(function () {
        Route::get('create', 'MoviesController@create')->name('movie.create');
        Route::post('', 'MoviesController@store')->name('movie.store');
        Route::delete('{id}', 'MoviesController@destroy')->name('movie.delete');
    });
});


