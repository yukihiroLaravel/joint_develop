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

//ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post'); //フォームに入力されたデータを実行
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// ログイン後
Route::group(['middleware' => 'auth'], function () {
    Route::delete('posts/{id}', 'PostsController@destroy')->name('post.delete'); //ユーザ削除
    Route::prefix('users/{id}')->group(function () {
        Route::get('edit', 'UsersController@edit')->name('user.edit');
        Route::put('/', 'UsersController@update')->name('user.update');
        // ユーザ詳細
        Route::get('/', 'UsersController@show')->name('user.show');
        // フォロー中
        Route::get('following','UsersController@following')->name('user.following');
        // フォロワー
        Route::get('followed','UsersController@followed')->name('user.followed');
        // フォローする
        Route::post('tofollow','FollowController@store')->name('tofollow');
        // フォロー外す
        Route::delete('unfollow','FollowController@destroy')->name('unfollow');
        // ユーザー退会
        Route::delete('', 'UsersController@destroy')->name('user.delete');
    });
});

//検索機能
Route::get('/', 'SearchController@search')->name('post.index');

// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// 新規投稿
Route::group(['middleware' => 'auth'], function () {
    Route::prefix('posts')->group(function () {
        Route::post('', 'PostsController@store')->name('post.store');
        Route::prefix('{id}')->group(function () {
            // 投稿編集画面
            Route::get('edit', 'PostsController@edit')->name('post.edit');
            // 投稿更新
            Route::put('', 'PostsController@update')->name('post.update');
            // 返信機能
            Route::post('replies', 'ReplyController@store')->name('post.replies');
            // 返信編集画面
            Route::get('reply/edit', 'ReplyController@edit')->name('reply.edit');
            // 返信更新
            Route::put('replies/update', 'ReplyController@update')->name('reply.update');
            // 返信削除
            Route::delete('replies/delete', 'ReplyController@destroy')->name('reply.delete');
            // 画像のみ削除（返信）
            Route::delete('picture/delete', 'ReplyController@imageDestroy')->name('picture.delete');
            // 画像のみ削除（トップページ）
            Route::delete('image/delete', 'PostsController@imageDestroy')->name('image.delete');
        });
    });
});
// 返信画面
Route::get('posts/{id}/reply', 'ReplyController@index')->name('post.reply');