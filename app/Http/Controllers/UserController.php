<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function edit($id)
    {
        if ($id == Auth::id()) {
            $user = User::findOrFail($id);
            return view('users.edit', [
                'user' => $user,
            ]);
        }
        abort(404);
    }

    public function update(UserRequest $request, $id)
    {
        if ($id == Auth::id()) {
            $user = User::findOrFail($id);
            $currentIcon = $user->icon;
            if (request()->file('icon')) {
                $userIcon = $this->userIcon($currentIcon);
            } else {
                $userIcon = $currentIcon;
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->icon = $userIcon;
            $user->save();
            $successMessage = "ユーザー情報を変更しました。";

            return view('users.edit', [
                'user' => $user,
                'successMessage' => $successMessage,
            ]);
        }
        abort(404);
    }

    public function userIcon($currentIcon)
    {
        $newIcon = request()->file('icon')->store('public/images');
        $newIcon = str_replace('public/images/', '', $newIcon);
        if ($currentIcon !== null) {
            Storage::disk('public')->delete('images/' . $currentIcon);
        }
        return $newIcon;
    }

    public function destroy($id)
    {
        if ($id == Auth::id()) {
            $user = User::findOrFail($id);
            $user->followUsers()->detach();
            foreach ($user->followerUsers as $followerUser) {
                $followerUser->followUsers()->detach($id);
            }
            Storage::disk('public')->delete('images/' . $user->icon);
            $user->delete();
            return redirect('/');
        }
        abort(404);
    }

    public function userRelation($id, $relation)
    {
        $user = User::findOrFail($id);
        if ($relation == 'follow') {
            $usersList = $user->followUsers();
        }
        if ($relation == 'follower') {
            $usersList = $user->followerUsers();
        }
        $usersList = $usersList->orderBy('id', 'desc')->paginate(10);
        $data = [
            'user' => $user,
            'usersList' => $usersList,
        ];
        $data += $this->userCounts($user);
        return $data;
    }

    public function followUsersShow($id)
    {
        $relation = 'follow';
        $data = $this->userRelation($id, $relation);
        return view('users.show', $data);
    }
    public function followerUsersShow($id)
    {
        $relation = 'follower';
        $data = $this->userRelation($id, $relation);
        return view('users.show', $data);
    }

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
}
