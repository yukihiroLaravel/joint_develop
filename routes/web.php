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

// トップページ
Route::get('/', 'PostsController@index')->name('posts.index');

// タグ別投稿一覧
Route::get('tags/{id}', 'TagsController@show')->name('tag.show');

// ユーザ新規登録画面を表示
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');

// ユーザ新規登録処理
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ログイン、ログアウト
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::prefix('users')->group(function () {
    // ユーザ詳細画面を表示
    Route::get('{id}', 'UsersController@show')->name('user.show');
    // ユーザ編集画面・更新
    Route::get('{id}/edit', 'UsersController@edit')->name('user.edit')->middleware('auth');
    Route::put('{id}', 'UsersController@update')->name('user.update')->middleware('auth');
    // フォロー中一覧
    Route::get('{id}/followings', 'UsersController@followings')->name('user.followings');
    // フォロワー一覧
    Route::get('{id}/followers', 'UsersController@followers')->name('user.followers');
    // フォロー実行
    Route::post('{id}/follow', 'FollowsController@store')->name('user.follow')->middleware('auth');
    // フォロー解除
    Route::delete('{id}/unfollow', 'FollowsController@destroy')->name('user.unfollow')->middleware('auth');
    // ユーザ退会処理
    Route::delete('{id}', 'UsersController@destroy')->name('user.destroy')->middleware('auth');
});

// 通知
Route::prefix('notifications')->middleware('auth')->group(function () {
    Route::get('', 'NotificationsController@index')->name('notifications.index');
    Route::patch('{id}/read', 'NotificationsController@markNotificationAsRead')->name('notifications.read');
});

// 投稿
Route::prefix('posts')->middleware('auth')->group(function () {
    Route::get('{id}', 'PostsController@show')->name('post.show');

    Route::prefix('{id}/reactions')->group(function () {
        Route::post('', 'ReactionsController@store')->name('reaction.store');
        Route::post('encouragement', 'ReactionsController@encourage')->name('reaction.encourage');
        //  ハゲマシへの返信投稿
        Route::post('{reaction}/replies', 'ReactionRepliesController@store')
            ->name('reaction_replies.store');
    });

    // ハゲマシへの返信削除
    Route::delete('replies/{replyId}', 'ReactionRepliesController@destroy')
        ->name('reaction_replies.destroy');

    // ハゲマシへの返信更新
    Route::put('replies/{replyId}', 'ReactionRepliesController@update')
        ->name('reaction_replies.update');

    Route::get('{id}/edit', 'PostsController@edit')->name('post.edit');
    Route::put('{id}', 'PostsController@update')->name('post.update');
    Route::delete('{id}', 'PostsController@destroy')->name('post.destroy');
    Route::post('', 'PostsController@store')->name('post.store');
});

// 管理者
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', 'AdminController@index')->name('admin.index');

    // ユーザー管理
    Route::prefix('users')->group(function () {
        Route::get('', 'AdminController@users')->name('admin.users');
        Route::delete('{id}', 'AdminController@destroyUser')->name('admin.users.destroy');
        Route::patch('{id}/restore', 'AdminController@restoreUser')->name('admin.users.restore');
        Route::patch('{id}/grant-admin', 'AdminController@grantAdmin')->name('admin.users.grant-admin');
        Route::delete('{id}/force', 'AdminController@forceDeleteUser')->name('admin.users.force-delete');
    });

    // 投稿管理
    Route::prefix('posts')->group(function () {
        Route::get('', 'AdminController@posts')->name('admin.posts');
        Route::delete('{id}', 'AdminController@destroyPost')->name('admin.posts.destroy');
        Route::patch('{id}/restore', 'AdminController@restorePost')->name('admin.posts.restore');
        Route::delete('{id}/force', 'AdminController@forceDeletePost')->name('admin.posts.force-delete');
    });

    // 管理者アカウント管理
    Route::prefix('admins')->group(function () {
        Route::get('', 'AdminUserController@index')->name('admin.admins.index');
        Route::get('create', 'AdminUserController@create')->name('admin.admins.create');
        Route::post('', 'AdminUserController@store')->name('admin.admins.store');
        Route::get('{id}/edit', 'AdminUserController@edit')->name('admin.admins.edit');
        Route::put('{id}', 'AdminUserController@update')->name('admin.admins.update');
        Route::patch('{id}/revoke', 'AdminUserController@revoke')->name('admin.admins.revoke');
        Route::delete('{id}/force', 'AdminUserController@forceDelete')->name('admin.admins.force-delete');
    });
});