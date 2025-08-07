<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\User;
use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class UsersController extends Controller
{
    public function show($id, Request $request)
    {
        $user = User::findOrFail($id);
        $tab = $request->query('tab', 'timeline');
        $posts = $user->posts()->with('user')->orderBy('id', 'desc')->paginate(10); // ユーザの投稿を取得
        $followingUsers = $user->followings()->paginate(10); // フォロー中のユーザを取得
        $followers = $user->followers()->paginate(10); // フォロワーを取得
        
        $data=[
            'user' => $user,
            'tab' => $tab,
            'posts' => $posts,
            'followingUsers' => $followingUsers,
            'followers' => $followers,
            'followersCount' => $user->followers()->count(),
            'followingCount' => $user->followings()->count(),
        ];
        return view('users.show',$data);
    }

    public function following($id)
    {
        $user = User::findOrFail($id);
        $followingUsers = $user->following()->get();

        return view('users.following', compact('user', 'followingUsers'));
    }

    public function followers($id)
    {
        $user = User::findOrFail($id);
        $followers = $user->followers()->get();

        return view('users.followers', compact('user', 'followers'));
    }



    public function edit($id)
    {
        $user = User::findOrFail($id);       
        if (\Auth::id() === $user->id) {                      
            return view('users.edit',[
                'user' => $user,
            ]);
        }
        return back();
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        if (\Auth::id() === $user->id) {        
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);     
            $user->save();           
        }     
        return redirect()->route('users.show', ['id' => $id])->with('success', 'ユーザ情報を更新しました。');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (\Auth::id() === $user->id) {
            $user->delete();
        }
        return redirect('/')->with('success', 'ユーザ情報を削除しました。');
    }
}