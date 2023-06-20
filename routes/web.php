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

// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');
// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');


// トップページ
Route::get('/', 'postsController@index');
// ユーザー編集、更新
Route::group(['middleware' => 'auth'], function () 
{  
    Route::group(['prefix' => 'users'],function()
    {
        Route::get('{id}/edit', 'UsersController@edit')->name('users.edit');
        Route::put('{id}', 'UsersController@update')->name('users.update');
        Route::delete('{id}', 'UsersController@destroy')->name('users.delete');
    });
});

// ユーザ
Route::prefix('users')->group(function () {
    Route::get('{id}', 'UsersController@show')->name('user.show');
    //ユーザー詳細イイね
    Route::get('{id}/favorites', 'UsersController@favorites')->name('favorites');
    //　ユーザー詳細「フォロー中」
    Route::get('{id}/followings', 'UsersController@followingsShow')->name('followings');
    //　ユーザー詳細「フォワー」
    Route::get('{id}/followers', 'UsersController@followersShow')->name('followers');
    // フォロー機能（ログイン後）
    Route::post('{id}/follow', 'FollowController@store')->name('follow');
    Route::delete('{id}/unFollow', 'FollowController@destroy')->name('unFollow');
});

// ログイン後
Route::group(['middleware' => 'auth'], function () {
    // 投稿新規作成（投降削除はこれから実装予定）
    Route::prefix('posts')->group(function () {
        Route::post('', 'PostsController@store')->name('post.store');
        Route::delete('{id}', 'PostsController@destroy')->name('post.delete');
        Route::get('{id}/edit', 'PostsController@edit')->name('post.edit');
        Route::put('{id}', 'PostsController@update')->name('post.update');
    });
    //イイね
    Route::group(['prefix' => 'posts/{id}'],function(){
        Route::post('favorite', 'FavoriteController@store')->name('favorite');
        Route::delete('unfavorite', 'FavoriteController@destroy')->name('unfavorite');
    });
});