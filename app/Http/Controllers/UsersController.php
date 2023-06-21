<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
    
    public function showFollowingList($id)
    {
        $user = User::findOrFail($id);
        $followingUsers = $user->following()->orderBy('id', 'desc')->paginate(10);
        $data = [
            'user' => $user,
            'followingUsers' => $followingUsers,
        ];
        $data += $this->userCounts($user);
        return view('follow.following_list', $data);
    }
    
    public function showFollowedList($id)
    {
        $user = User::findOrFail($id);
        $followedUsers = $user->followed()->orderBy('id', 'desc')->paginate(10);
        $data = [
            'user' => $user,
            'followedUsers' => $followedUsers,
        ];
        $data += $this->userCounts($user);
        return view('follow.followed_list', $data);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        if ($user->id === \Auth::id()) {
            return view('users.edit', ['user' => $user]);
        }
        abort(404);
    }

    public function update(UserRequest $request, $id)
    {
        $updateUser = $request->all();
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        if ($request->profile_image != null) {
            $file_name = $request->file('profile_image')->getClientOriginalName();
            $request->file('profile_image')->storeAs('public/images/profiles/' . $id, $file_name);
            $profileImagePath = $id . '/' . $file_name;
            $updateUser['profile_image'] = $profileImagePath;
        }
        $loginUser = Auth::user();
        $loginUser->fill($updateUser)->save();
        return redirect()->route('user.show', $user->id)->with('greenMessage', '更新しました');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->id === \Auth::id()) {
            $user->delete();
            return redirect('/')->with('redMessage', '退会しました');
        }
        return back();
    }
}
