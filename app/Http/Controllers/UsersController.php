<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\User;
use App\Post;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UsersController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $post = $user->posts()->orderBy('id', 'desc')->paginate(10);
        $data=[
            'user' => $user,
            'posts' => $post,
        ];
        return view('users.show',$data);
    }

    //ユーザ編集画面・更新
    public function edit($id)
    {
        $user = User::findOrFail($id);
        if (Auth::user()->id !== $user->id) {
            abort(403);
        }
        return view('users.edit', ['user' => $user]);
    }   
    
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password); 
        $user->save();
        return back()->with('flashSuccess', 'ユーザ情報を更新しました。');
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect('/')->with('flashSuccess', '退会しました。');
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