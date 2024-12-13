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

// トップページの表示と検索機能
Route::get('/', 'SearchController@index')->name('search.index');

// ユーザ
Route::prefix('users')->group(function () {
    Route::get('{id}', 'UsersController@show')->name('user.show');
    Route::delete('{id}/delete', 'UsersController@destroy')->name('user.delete');
});
// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// 投稿詳細画面表示
Route::get('posts/{id}/show', 'PostsController@show')->name('post.show');
Route::group(['middleware' => 'auth'], function () {
    Route::prefix('posts')->group(function () {
        // 投稿新規登録
        Route::post('', 'PostsController@store')->name('post.store');
        // 投稿編集画面表示
        Route::get('{id}/edit', 'PostsController@edit')->name('post.edit');
        // 投稿編集
        Route::put('{id}', 'PostsController@update')->name('post.update');
        // Like Button
        Route::post('{id}/like', 'LikeController@store')->name('posts.like');
        Route::delete('{id}/unlike', 'LikeController@destroy')->name('posts.unlike');
        // コメント
        Route::post('{post}/comments', 'CommentController@store')->name('comments.store');
        // 投稿削除
        Route::delete('{id}', 'PostsController@destroy')->name('post.delete');
    });
});

// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// ユーザ編集・更新
Route::group(['middleware' => 'auth'], function () {
    Route::prefix('users')->group(function () {
        Route::get('{id}/edit', 'UsersController@edit')->name('user.edit');
        Route::put('{id}', 'UsersController@update')->name('user.update');
    });
    Route::delete('/profile/avatar', 'UsersController@deleteAvatar')->name('profile.avatar.delete');
});

// Follow & Unfollow
Route::group(['middleware' => 'auth'], function () {
    Route::post('/follow/{id}', 'FollowController@store')->name('follow');
    Route::delete('/unfollow/{id}', 'FollowController@destroy')->name('unfollow');
    Route::get('users/{id}/followings', 'UsersController@getFollowings')->name('users.followings');
    Route::get('users/{id}/followers', 'UsersController@getFollowers')->name('users.followers');
});