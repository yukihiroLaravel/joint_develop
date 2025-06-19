<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    //ユーザ詳細
    public function show($id)
    {
        $keyword = '';
        $user = User::findOrFail($id); // ユーザーが見つからなければ404エラー
        // 自分とフォロー中のユーザーIDを配列で取得
        $followedUserIds = $user->followings()->pluck('users.id')->toArray();
        $followedUserIds[] = $user->id;
        // 投稿を取得（自分＋フォロー中）＆ページネーション
        $posts = Post::whereIn('user_id', $followedUserIds)
            ->orderBy('created_at', 'desc')
            ->paginate(9);
        return view('users.show', compact('user', 'posts', 'keyword')); // ビューにデータを渡す
    }

    // 編集画面
    public function edit($id)
    {
        $user = User::findOrFail($id);
        if (Auth::id() != $id) {
            abort(403);
        }
        return view('users.edit', ['user' => $user]);
    }

    // 更新処理(担当：なり)
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect()->route('user.show', $user->id);
    }

    // 退会処理
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (Auth::id() != $id) {
            abort(403);
        }
        $user->posts()->delete();
        $user->delete();
        return redirect('/');
    }

    //自分がフォローしているユーザー一覧
    public function followings($id)
    {
        $user = User::findOrFail($id);
        //検索キーワード取得（未入力ならnull）
        $search = request('search');
        //検索があればnameで絞り込み
        $query = $user->followings();
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        //データ取得
        $followings = $query->get();
        $data = [
            'user' => $user,
            'users' => $followings,
        ];
        $data += $this->userCounts($user);

        return view('users.followings', $data);
    }
        
    //自分をフォローしているユーザー一覧
    public function followers($id)
    {
        $user = User::findOrFail($id);
        //検索キーワード取得
        $search = request('search');
        //検索があればnameで絞り込み
        $query = $user->followers();
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        // データ取得
        $followers = $query->get();
        $data = [
            'user' => $user,
            'users' => $followers,
        ];
        $data += $this->userCounts($user);

        return view('users.followers', $data);
    }

    protected function userCounts($user)
    {
        return [
        'count_posts' => $user->posts()->count(),
        'count_followings' => $user->followings()->count(),
        'count_followers' => $user->followers()->count(),
        ];
    }
}
