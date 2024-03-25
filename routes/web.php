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

//ユーザー新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// ユーザ新規登録
    // 新規登録画面表示
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
    // 新規登録実行
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ユーザ（詳細、編集、更新、削除）
Route::prefix('users/{id}')->group(function () {
    Route::get('/', 'UsersController@show')->name('users.show');
    Route::group(['middleware' => 'auth'], function () {
            Route::get('edit', 'UsersController@edit')->name('users.edit');
            Route::put('/', 'UsersController@update')->name('users.update');
            Route::delete('/', 'UsersController@destroy')->name('users.delete');
            // フォロー機能
            Route::post('follow', 'FollowController@store')->name('follow');
            Route::delete('unFollow', 'FollowController@destroy')->name('unFollow');
            Route::get('follows', 'FollowController@follows')->name('user.follows');
            Route::get('followers', 'FollowController@followers')->name('user.followers');
    });
});

// 投稿一覧表示
Route::get('/', 'PostsController@index')->name('posts');
// 投稿関連
Route::group(['middleware' => 'auth'], function () {
    // 投稿新規作成
        Route::post('/','PostsController@store')->name('posts.store');                
    });
//ユーザ詳細
Route::get('users/{id}', 'UsersController@show')->name('user.show');

// トップページ表示
Route::get('/', 'PostsController@index')->name('welcome');//トップページへの遷移

// 検索機能
Route::get('search', 'PostsController@search')->name('posts.search');

// ログイン後
Route::group(['middleware' => 'auth'], function () {
    Route::prefix('users')->group(function() {
        // ユーザ編集/更新
        Route::get('{id}/edit', 'UsersController@edit')->name('user.edit');
        Route::put('{id}', 'UsersController@update')->name('user.update');
        // ユーザ退会
        Route::delete('{id}', 'UsersController@destroy')->name('user.delete');
        // ユーザ詳細
        Route::get('{id}', 'UsersController@show')->name('user.show');
        //いいね
        Route::get('{id}/favorites','UsersController@favorites')->name('user.favorites');
        Route::post('{id}/favorite','FavoriteController@store')->name('favorite');
        Route::delete('{id}/unfavorite','FavoriteController@destroy')->name('unfavorite');
    });

    Route::prefix('posts')->group(function() {
        // 投稿投稿作成/編集/更新
        Route::post('', 'PostsController@store')->name('post.store');
        Route::get('{id}/edit', 'PostsController@edit')->name('post.edit');
        Route::put('{id}', 'PostsController@update')->name('post.update');
        // 投稿削除
        Route::delete('{id}', 'PostsController@destroy')->name('post.delete');
    });

    //コメント投稿機能/一覧表示/コメント詳細
    Route::prefix('comments')->group(function() {
        Route::post('', 'CommentsController@store')->name('comments.store');
        Route::get('{id}', 'CommentsController@show')->name('comments.show');
    });
});