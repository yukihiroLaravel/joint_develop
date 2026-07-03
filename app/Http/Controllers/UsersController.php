<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            ->orderBy('id', 'desc')
            ->paginate(10);

        $data = [
            'user' => $user,
            'posts' => $posts,
            'type' => 'timeline',
        ];

        return view('users.show', $data);
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
