<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Http\Requests\UserRequest;


class UsersController extends Controller
{
    public function edit($id)
    {
        if ($id == \Auth::id()) 
        {
            $user = User::findOrFail($id);
            $data=[
                'user' => $user,
            ];
            return view('users.edit', $data);
        }
        return view('errors.404');
    }

    public function update(UserRequest $request, $id)
    {
        if ($id == \Auth::id()) {
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);

            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/uploads/' . $user->id, $imageName);
                $user->profile_image = $imageName;
            }
            $user->save();

            // 更新後のユーザー情報を再取得
            $user = User::findOrFail($id);

            // ビューにユーザー情報とフラッシュメッセージを渡す
            $data = [
                'user' => $user,
                'posts' => $user->posts()->orderBy('id', 'desc')->paginate(10),
                'flash_message' => '更新しました！'
            ];

            return view('users.show', $data);
        }

    return view('errors.404');
}
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($id == \Auth::id()) 
        {
            $user->delete();
        }
        return redirect('/')->with('withdraw_message', '退会しました');
    }

    //ユーザー詳細　paginateは他のタブに合わせて(9)から(10)に変更しました
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(10);
        $countPosts = $user->posts()->count();
        $countFollowings = $user->followings()->count();
        $countFollowers = $user->followers()->count();
        $countFavorites = $user->favorites()->count();

        return view('users.show', [
            'user' => $user,
            'posts' => $posts,
            'countPosts' => $countPosts,
            'countFollowings' => $countFollowings,
            'countFollowers' => $countFollowers,
            'countFavorites' => $countFavorites,
        ]);
    }
    //ユーザー詳細「フォロー中」
    public function followingsShow($id)
    {
        $user = User::findOrFail($id);
        $relations = $user->followings()->orderBy('created_at', 'desc')->paginate(10);
        $data = [
            'user' => $user,
            'relations' => $relations,
        ];
        $data += $this->userCounts($user);
        return view('follow.followings', $data);
        
    }

    //ユーザー詳細「フォロワー」
    public function followersShow($id)
    {
        $user = User::findOrFail($id);
        $relations = $user->followers()->orderBy('created_at', 'desc')->paginate(10);
        $data = [
            'user' => $user,
            'relations' => $relations,
        ];
        $data += $this->userCounts($user);
        return view('follow.followers', $data);
    }

    public function favorites($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->favorites()->paginate(9);
        $data = [
            'user' => $user,
            'posts' => $posts,
        ];
        $data += $this->userCounts($user);
        return view('users.show',$data);
    }

}
