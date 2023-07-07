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
Route::get('/', 'postsController@index')->name('top');
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
Route::prefix('users/{id}')->group(function () {
    Route::get('', 'UsersController@show')->name('user.show');
    //　ユーザー詳細「フォロー中」
    Route::get('followings', 'UsersController@followingsShow')->name('followings');
    //　ユーザー詳細「フォワー」
    Route::get('followers', 'UsersController@followersShow')->name('followers');
    // フォロー機能（ログイン後）
    Route::post('{follow', 'FollowController@store')->name('follow');
    Route::delete('unFollow', 'FollowController@destroy')->name('unFollow');

    //ユーザー詳細イイね
    Route::get('favorites', 'UsersController@favorites')->name('favorites');
    //ユーザー詳細コメントへのイイね（ワロタ）
    Route::get('comment_favorites', 'UsersController@favoritesComments')->name('comment.favorites');
});

// ログイン後
Route::group(['middleware' => 'auth'], function () {
    // 投稿（新規作成、削除、編集、更新）
    Route::prefix('posts')->group(function () {
        Route::post('', 'PostsController@store')->name('post.store');
        Route::delete('{id}', 'PostsController@destroy')->name('post.delete');
        Route::get('{id}/edit', 'PostsController@edit')->name('post.edit');
        Route::put('{id}', 'PostsController@update')->name('post.update');
        // コメント（新規作成、削除、編集更新）
        Route::post('{id}/comments', 'CommentController@store')->name('comment.store');
        Route::delete('{postId}/comments/{commentId}', 'CommentController@destroy')->name('comment.delete');
        Route::get('{postId}/comments/{commentId}/edit', 'CommentController@edit')->name('comment.edit');
        Route::put('{postId}/comments/{commentId}', 'CommentController@update')->name('comment.update');
    });
    //イイね
    Route::group(['prefix' => 'posts/{id}'],function(){
        Route::post('favorite', 'FavoriteController@store')->name('favorite');
        Route::delete('unfavorite', 'FavoriteController@destroy')->name('unfavorite');
    });
    //コメントのイイね
    Route::group(['prefix' => 'comments/{commentId}'], function () {
        Route::post('favorite', 'FavoriteController@commentStore')->name('comment.favorite');
        Route::delete('unfavorite', 'FavoriteController@commentDestroy')->name('comment.unfavorite');
    });
});

// 回答投稿ページ 兼 回答一覧ページ
Route::get('/posts/{id}', 'CommentController@show')->name('comment.show');
Route::get('/comments', 'CommentController@index')->name('comment.index');
