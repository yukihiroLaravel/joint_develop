<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UserRequest;
use App\User;
use App\Post;

class UsersController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(10);

        $data = [
            'user' => $user,
            'posts' => $posts,
        ];

        $data += $this->userCounts($user);

        return view('users.show', $data);
    }

    public function edit($id)
    {
        if ($id == Auth::id()) {
            $data = [
                'user' => Auth::user()->id,
            ];
            return view('users.edit', $data);
        } else {
            abort(403); // アクセス権無し
        }
    }

    public function update(UserRequest $request, $id)
    {
        if ($id == Auth::id()) {
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            return redirect()->route('users.show', $user->id);
        }
    }

    public function followings($id)
    {
        $user = User::findOrFail($id);
        $followings = $user->followings()->orderBy('created_at', 'desc')->paginate(10);
       
        $data = [
            'user' => $user,
            'followings' => $followings,
        ];
        $data += $this->userCounts($user);
        
        return view('users.followings', $data);
    }

    public function followers($id)
    {
        $user = User::findOrFail($id);
        $followers = $user->followers()->orderBy('created_at', 'desc')->paginate(10);

        $data = [
            'user' => $user,
            'followers' => $followers,
        ];
        $data += $this->userCounts($user);
    
        return view('users.followers', $data);
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'required|file|image|max:2048',
            ]);

            $path = $request->file('image')->store('images', 'public');
            $filename = basename($path);
            // これは 'storage/app/public/images' に画像を保存するコード

            $user = Auth::user(); // ログイン中のユーザーを取得
            $user->profile_image = $filename; // ファイル名をユーザーレコードに保存
            $user->save(); // ユーザーレコードを更新

            return back()->with('path', $path);
        } else {
            // ファイルがアップロードされていない場合のエラーメッセージ
            return back()->withErrors('No file was uploaded.');
        }
    }

    public function updateProfile(Request $request, User $user)
    {
        $data = $request->all();
        
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            
            // 既存の画像があれば削除
            if ($user->profile_image) {
                Storage::disk('public')->delete('images/' . $user->profile_image);
            }

            $file->storeAs('images', $filename, 'public');
            $data['profile_image'] = $filename;
        }

        $user->update($data);
        return back();
    }

}