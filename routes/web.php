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
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

Route::get('/ranking/followers', 'UsersController@followerRanking')->name('ranking.followers');
Route::get('/ranking/favorites', 'UsersController@favoriteRanking')->name('ranking.favorites');

Route::prefix('users/{id}')->group(function () {
    Route::get('', 'UsersController@show')->name('user.show');
    Route::get('follows', 'UsersController@follows')->name('user.follows');
    Route::get('followers', 'UsersController@followers')->name('user.followers');
    Route::get('avatar/edit', 'UsersController@editAvatar')->name('user.avatar.edit');
    Route::put('avatar/update', 'UsersController@updateAvatar')->name('user.avatar.update');
});

Route::group(['middleware' => 'auth'], function () {
    Route::prefix('posts')->group(function () {
        // 画像削除
        Route::delete('{post}/image', 'PostsController@destroyImage')->name('post.image.destroy');
        Route::prefix('{post_id}/replies/{reply}')->group(function () {
            Route::get('edit', 'RepliesController@edit')->name('replies.edit');
            Route::put('/', 'RepliesController@update')->name('replies.update');
            Route::delete('/', 'RepliesController@destroy')->name('replies.destroy');
        });

        Route::post('', 'PostsController@store')->name('posts.store');
        Route::get('{id}/edit', 'PostsController@edit')->name('post.edit');
        Route::put('{id}', 'PostsController@update')->name('post.update');
        Route::delete('{id}', 'PostsController@destroy')->name('post.destroy');
        
        Route::post('{id}/replies', 'RepliesController@store')->name('replies.store');
        
    });

    Route::prefix('users')->group(function () {
        Route::get('{id}/edit', 'UsersController@edit')->name('user.edit');
        Route::put('{id}', 'UsersController@update')->name('user.update');
        Route::delete('{id}', 'UsersController@withdrawal')->name('user.withdrawal');
    });

    Route::group(['prefix' => 'users/{id}'], function() {
        Route::post('follow', 'FollowController@store')->name('follow');
        Route::delete('unfollow', 'FollowController@destroy')->name('unfollow');
    });
     
    // 良いね機能
    Route::group(['prefix' => 'posts/{id}'],function(){
        Route::post('favorite','FavoriteController@store')->name('favorite');
        Route::delete('unfavorite','FavoriteController@destroy')->name('unfavorite');
    });

    // タグの追加・削除（middleware: auth 内）
    Route::post('/tags', 'TagController@store')->name('tags.store');
    Route::delete('/tags/{id}', 'TagController@destroy')->name('tags.destroy');
});   

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/', 'PostsController@index')->name('post.index');
Route::get('posts/{id}', 'PostsController@show')->name('post.show');

// タグ
Route::get('/tags/{id}', 'TagController@search')->name('tags.search');

