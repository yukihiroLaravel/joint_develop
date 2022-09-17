<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserEditRequest;

class UsersController extends Controller
{
    public function edit($id)
    {
        $user = User::findOrFail($id);
        if(\Auth::id() === $user->id) {
            return view('users.edit', [
                'user' => $user
            ]);
        }else{
            return redirect('User::findOrFail($id)');
        }
        return back();
    }

    public function update(UserEditRequest $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            if(\Auth::id() === $user->id) {
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                $user->save();
            }
            $request->session()->flash('content', 'ユーザ情報が変更されました');
        } catch(Throwable $e) {
            $request->session()->flash('error_content', 'ユーザ情報が変更されませんでした');
        }
        return redirect(route('user.show', $id));
    }
    
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(9);
        $data= [
            'user' => $user,
            'posts' => $posts,
        ];
        return view('users.show',$data);
    }

    public function followings($id)
    {
        $user = User::find($id);
        $followings = $user->followings()->paginate(9);
        $data = [
            'user' => $user,
            'users' => $followings,
        ];
        $data += $this->counts($user);
        return view('users.followings', $data); 
    }

    public function followers($id)
    {
        $user = User::find($id);
        $followers = $user->followers()->paginate(9);
        $data = [
            'user' => $user,
            'users' => $followers,
        ];
        $data += $this->counts($user);
        return view('users.followers', $data);
    }
    
    public function destroy($id)
    {
        $user = User::find($id);
        if (\Auth::id() === $user->id) {
            $user->delete();
        }
        return redirect('/');
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
