<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use App\Http\Request\UsersRequest;

class UsersController extends Controller
{
    public function edit($id)
    {
        $user = \Auth::user();
        if ($id == $user->id) {
        $data = [
            'user' => $user,
        ];
        return view('users.edit', $data);
        } else {
        return redirect('/');
        }
    }

    public function update(UsersRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password); 
        $user->save();
        return back()->with('usersUpdateMessage', 'ユーザ情報編集に成功しました');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(10);
        $data=[
            'posts' => $posts,
            'user' => $user,
        ];
        $data += $this->userCounts($user);
        return view('users.show',$data);
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (\Auth::id() === $user->id) {
            $user->delete();
        }
        return redirect('/')->with('usersdestroyMessage', '退会に成功しました');
    }
    
}    