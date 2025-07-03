<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
｛
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(10);
        $data = [
            'user' => $user,
            'posts' => $posts,
        ];
        $data += $this->userCounts($user);

        return view('users.show',$data);
    }
｝
    public function edit($id)
    {
        $user = \Auth::user();
        $user = User::findOrFail($id);

        if (\Auth::id() != $id) {
            abort(403);
        }

        $data=[
            'user' => $user,
        ];

        return view('users.edit', $data);

    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        return redirect()->route('user.show', $user->id)->with('success', '「ユーザ情報の更新」が完了しました！');
    }

    public function withdrawal($id, Request $request)
    {
        $user = User::findOrFail($id);
        if(Auth::id() !== $user->id){
            abort(403);
        }
        $user->delete();

        Auth::logout();
        
        return redirect()->route('post.index')->with('success', '退会が完了しました！');
    }

    public function follows($id)
    {
        $user = User::with('follows')->findOrFail($id);
        $followers = $user->follows()->get();
        $data=[
            'user' => $user,
            'followers' => $followers,  
        ];
        $data += $this->userCounts($user);
        
        return view('users.show', $data);   
    }

    public function followers($id)
    {
        $user = User::with('followers')->findOrFail($id);
        $followers = $user->followers()->get();
        $data=[
            'user' => $user,
            'followers' => $followers,  
        ];
        $data += $this->userCounts($user);
        
        return view('users.show', $data);   

    }

    public function editAvatar($id)
    {
        $user = User::findOrFail($id);

        // 本人でない場合は拒否（セキュリティ）
        if (auth()->id() !== $user->id) {
            return redirect()->route('user.show', $id)->with('error', '不正な操作です。');
        }

        return view('users.edit_avatar', compact('user'));
    }

    public function updateAvatar(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() !== $user->id) {
            return redirect()->route('user.show', $id)->with('error', '不正な操作です。');
        }

        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if ($request->hasFile('avatar')) {
            // 古い画像削除
            if ($user->avatar) {
                \Storage::delete('public/' . $user->avatar);
            }

            // 新しい画像保存
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
            $user->save();

            return redirect()->route('user.show', $user->id)->with('success', 'アイコンを変更しました');
        }
    }

    public function favoriteRanking() 
    {
        $rankingUsers = User::select('users.*', DB::raw('COALESCE(SUM(fav_count), 0) as likes_received_count'))
            ->leftJoin('posts', 'users.id', '=', 'posts.user_id')
            ->leftJoin(DB::raw('(SELECT post_id, COUNT(*) as fav_count FROM favorites GROUP BY post_id) as f'), 'posts.id', '=', 'f.post_id')
            ->groupBy('users.id')
            ->orderByDesc('likes_received_count')
            ->take(10)
            ->get();

        return view('users.nice_ranking', compact('rankingUsers'));
    }
