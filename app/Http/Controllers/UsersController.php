<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $user = Auth::user();  //ログインユーザーの情報取得
        $AccessUser = User::find($id);  //リクエスト$idが一致するユーザーの情報取得
        if(!$AccessUser)
        {
            return abort(404); // 存在しないユーザー、全体修正時に推敲？
        }
        if($user->id === $AccessUser->id)
        {
            $data = [
                'user' => $user,
            ];
            return view('users.edit', $data);
        }else
        {
            return abort(403); // アクセス権無し、全体修正時に推敲？
        }
    }

    public function update(UserRequest $request, $id)
    {
        if ($id == Auth::id())
        {
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            // return redirect('/');
            // return view('users.show', $user->id);
            return redirect()->route('users.show', $user->id);
        }
    }
}