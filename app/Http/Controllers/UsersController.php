<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\User;
use App\Posts;


class UsersController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id','desc')->paginate(10);
        $data = [
            'user' => $user,
            'posts' => $posts,
        ];
        return view('users.show',$data);
    }

    public function edit($id)
    {
        if ($id == \Auth::id()) {
            $user = \Auth::user();
            $data = [
                'user' => $user
            ];
            return view('users.edit', $data);
        }
        abort(404);
    }

    public function update(UserRequest $request, $id)
    {
    $user = User::findOrFail($id);
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = bcrypt($request->password);
    $user->save();
    return redirect()->route('users.show', $user->id)->with('successMessage','ユーザー情報が更新されました');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (\Auth::id() === $user->id) {
            $user->delete();
        } 
        return redirect('/')->with('alertMessage', '退会が完了しました');
    }
}