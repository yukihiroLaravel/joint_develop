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
Route::get('/', 'UsersController@index');

//投稿の検索
Route::get('index', 'PostsController@index')->name('posts.index');

Route::group(['prefix' => 'user/{id}'],function(){
    //ユーザー詳細
    Route::get('', 'UsersController@show')->name('user.show');
    //各ユーザーがフォローしている一覧
    Route::get('follows','UsersController@followings')->name('user.follows');
    //各ユーザーがフォローされている一覧
    Route::get('followers','UsersController@followers')->name('user.followers');
});

// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');


// ログイン後
Route::group(['middleware' => 'auth'], function () {
    Route::prefix('user')->group(function () {
        // ユーザー編集、更新
        Route::get('{id}/edit', 'UsersController@edit')->name('user.edit');
        Route::put('{id}', 'UsersController@update')->name('user.update');
        // ユーザー退会
        Route::delete('{id}', 'UsersController@destroy')->name('user.destroy');
    });

    Route::prefix('post')->group(function () {
        //投稿新規作成
        Route::post('', 'PostsController@store')->name('post.store');
        // 投稿の編集、更新
        Route::get('{id}/edit', 'PostsController@edit')->name('post.edit');
        Route::put('{id}', 'PostsController@update')->name('post.update');
        // 投稿の削除
        Route::delete('{id}', 'PostsController@destroy')->name('post.delete');
        // 投稿画像の削除
        Route::delete('{id}/delete', 'PostsController@destroyImage')->name('post.image_delete');

        //コメントをするページへ遷移
        Route::get('{id}/comment','CommentController@create')->name('comment.create');
        //コメントを保存
        Route::post('comment','CommentController@store')->name('comment.store');
    });

    Route::group(['prefix' => 'user/{id}'],function(){
        //フォロー実行
        Route::post('follow','FollowController@store')->name('follow');
        //フォロー外す
        Route::delete('unfollow','FollowController@destroy')->name('unfollow');
    });
});