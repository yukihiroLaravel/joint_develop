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

//トップページ
Route::get('/', 'PostsController@index');

// 投稿検索
Route::get('search', 'PostsController@search')->name('posts.search');

//新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// ユーザ詳細
Route::prefix('users')->group(function () {
    Route::get('{id}', 'UsersController@show')->name('user.show');
});

// ログイン後
Route::group(['middleware' => 'auth'], function () {
    // 投稿に関するルート
    Route::post('posts', 'PostsController@store')->name('post.store');
    // 編集
    Route::get('posts/{id}/edit', 'PostsController@edit')->name('posts.edit');
    Route::put('posts/{id}', 'PostsController@update')->name('posts.update');
    
    Route::prefix('users/{id}')->group(function () {
        // ユーザー情報
        Route::get('/edit', 'UsersController@edit')->name('user.edit');
        Route::put('/', 'UsersController@update')->name('user.update');
        Route::delete('/', 'UsersController@destroy')->name('user.delete');
        // フォロー、解除
        Route::post('follow','FollowController@store')->name('follow');
        Route::delete('unfollow','FollowController@destroy')->name('unfollow');
        // フォロー、フォロワーの表示
        Route::get('followings', 'UsersController@followings')->name('users.followings');
        Route::get('followers', 'UsersController@followers')->name('users.followers');
        // いいね一覧（自分のみ）
        Route::get('favorites', 'UsersController@favorites')->name('users.favorites');
    });
    // いいね機能
    Route::group(['prefix' => 'posts/{id}'], function () {
        Route::post('favorite', 'FavoritesController@store')->name('favorites.favorite');
        Route::delete('unfavorite', 'FavoritesController@destroy')->name('favorites.unfavorite');
    });
});
