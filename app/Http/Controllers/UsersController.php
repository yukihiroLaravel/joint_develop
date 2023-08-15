<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id','desc')->paginate(9);
        return view('welcome', [
            'posts' => $posts,
        ]);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(9);
        //ユーザー詳細（タイムライン）に切り替わった時、posts.postsのみ読み込む
        $followingsShow = false;
        $followersShow = false;
        $timelineShow = true;

        $data = [
            'user' => $user,
            'posts' => $posts,
            'followingsShow' => $followingsShow,
            'followersShow' => $followersShow,
            'timelineShow' => $timelineShow,
        ];
        $data += $this->userCounts($user);
        return view('users.show',$data);
    }

    public function edit($id)
    {
        if(\Auth::id() == ($id)){
            $user = \Auth::user();
            $data = [
                'user' => $user,
            ];
            return view('users.edit', $data);
        } else {
            return back();
        }
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return back()->with('messageSuccess', 'ユーザー情報を更新しました');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (\Auth::id() === $user->id) {
            $user->delete();
        }
        return redirect('/')->with('messageDelete', '退会しました');
    }

    public function followings($id)
    {
        $user = User::findOrFail($id);

        //ユーザー詳細画面に遷移したユーザーの投稿一覧
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(9);

        //このユーザーがフォローしているユーザー一覧
        $follows = $user->followings()->paginate(9);
        //フォロー中にタブが切り替わった時、users.followのみ読み込む
        $followingsShow = true;
        $followersShow = false;
        $timelineShow = false;

        $data = [
            'user' => $user,
            'follows' => $follows,
            'posts' => $posts,
            'followingsShow' => $followingsShow,
            'followersShow' => $followersShow ,
            'timelineShow' => $timelineShow,
        ];
        $data += $this->userCounts($user);
        return view('users.show', $data);
    }

    public function followers($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(9);
        //このユーザーをフォローしている一覧
        $followers = $user->followers()->paginate(9);
        //フォロワーにタブが切り替わった時、users.followerのみ読み込む
        $followersShow = true;
        $followingsShow = false;
        $timelineShow = false;

        $data = [
            'user' => $user,
            'followers' => $followers,
            'posts' => $posts,
            'followersShow' => $followersShow,
            'followingsShow' => $followingsShow,
            'timelineShow' => $timelineShow,
        ];
        $data += $this->userCounts($user);
        return view('users.show', $data);
    }
}
