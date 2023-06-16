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
        if ($id == \Auth::id()) 
        {
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();            
        }
        return redirect('/')->with('flash_message', '更新しました！');    
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
        $data=[
            'user' => $user,
            'posts' => $posts,
        ];
        $data += $this->userCounts($user);
        return view('users.show',$data);
    }

    //ユーザー詳細「フォロー中」
    public function followingsShow($id)
    {
        $user = User::findOrFail($id);
        $followings = $user->followings()->orderBy('created_at', 'desc')->paginate(10);
        $data = [
            'user' => $user,
            'followings' => $followings,
        ];
        $data += $this->userCounts($user);
        return view('follow.followings', $data);
        
    }

    //ユーザー詳細「フォロワー」
    public function followersShow($id)
    {
        $user = User::findOrFail($id);
        $followers = $user->followers()->orderBy('created_at', 'desc')->paginate(10);
        $data = [
            'user' => $user,
            'followers' => $followers,
        ];
        $data += $this->userCounts($user);
        return view('follow.followers', $data);
    }

}
