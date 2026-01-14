<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User; // 追記

class UsersController extends Controller
{   
    //ユーザ詳細
   public function show(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $tab = $request->get('tab', 'posts'); // posts / followings / followers

        if ($tab === 'followings') {
            $users = $user->followings()->paginate(10);
            $posts = null;
        } elseif ($tab === 'followers') {
            $users = $user->followers()->paginate(10);
            $posts = null;
        } else {
            $posts = $user->posts()->orderBy('id', 'desc')->paginate(9);
            $users = null;
        }

        return view('users.show', [
            'user' => $user,
            'posts' => $posts,
            'users' => $users,
            'tab' => $tab,
            'followings_count' => $user->followings()->count(),
            'followers_count' => $user->followers()->count(),
        ]);
    }
}