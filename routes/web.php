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

// ログイン・ログアウト
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

//top page 表示
Route::get('/', 'PostsController@index')->name('posts.index');
//ユーザー詳細
Route::prefix('users')->group(function () {
    Route::get('{id}', 'UsersController@show')->name('user.show');
});
// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');
//コメント関連
Route::prefix('comments')->group(function () {
    //コメント表示
    Route::get('index/{id}', 'CommentsController@index')->name('comment.index');
    //コメント作成画面
    Route::get('create/{id}', 'CommentsController@create')->name('comments.create');
});

//ログイン後
Route::group(['middleware' => 'auth'], function () {
    //ユーザー情報関連
    Route::prefix('users')->group(function () {
        Route::get('{id}/edit', 'UsersController@edit')->name('user.edit');
        Route::put('{id}', 'UsersController@update')->name('user.update');
        Route::delete('{id}', 'UsersController@destroy')->name('user.delete');
    });
    // 投稿関連
    Route::prefix('posts')->group(function () {
        Route::get('{id}/edit', 'PostsController@edit')->name('post.edit');
        Route::put('{id}', 'PostsController@update')->name('post.update');
        Route::delete('{id}', 'PostsController@destroy')->name('post.delete');
        Route::get('{id}', 'PostsController@show')->name('post.show'); // ここでposts.showを追加
    });
    //フォロー
    Route::group(['prefix' => 'user/{id}'], function () {
        Route::post('follows', 'FollowController@store')->name('follow');
        Route::delete('unfollow', 'FollowController@destroy')->name('unfollow');
    });
    //コメント関連
    Route::prefix('comments')->group(function () {
        //コメントを新規投稿する
        Route::post('/', 'CommentsController@store')->name('comments.store');
        //コメントの編集
        Route::get('{id}/edit', 'CommentsController@edit')->name('comments.edit');
        //コメントの更新
        Route::patch('{id}', 'CommentsController@update')->name('comments.update');
        //コメントの削除
        Route::delete('{id}', 'CommentsController@destroy')->name('comments.delete');
    });
});
