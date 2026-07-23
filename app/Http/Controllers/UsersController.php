<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Reaction;

class UsersController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        $posts = $user->posts()
            ->with(['user', 'reactions', 'tags'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        //リアクション種類一覧をviewに渡すため取得する(Minami)
        $reactionTypes = Reaction::TYPES;  // ←変数を作る

        $data = [
            'user' => $user,
            'posts' => $posts,
            'type' => 'timeline',
        // リアクション種類一覧をViewに渡す(Minami)
            'reactionTypes' => $reactionTypes,  // ←viewに渡す
        ];

        return view('users.show', $data);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        if (Auth::id() !== $user->id) {
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

        if (Auth::id() !== $user->id) {
            abort(403);
        }

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();
        return redirect()->route('user.show', $user->id);
    }

    public function followings($id)
    {
        $user = User::findOrFail($id);

        $followings = $user->followings()->paginate(10);

        $data = [
            'user' => $user,
            'users' => $followings,
            'type' => 'followings',
        ];

        return view('users.show', $data);
    }

    public function followers($id)
    {
        $user = User::findOrFail($id);

        $followers = $user->followers()->paginate(10);

        $data = [
            'user' => $user,
            'users' => $followers,
            'type' => 'followers',
        ];

        return view('users.show', $data);
    }

    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (Auth::id() !== $user->id) {
            abort(403);
        }

        $user->delete();

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
