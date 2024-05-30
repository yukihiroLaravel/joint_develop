<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\User;
use App\Post;
use Illuminate\Support\Facades\Hash;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    // ユーザ詳細
    public function show(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $keyword = $request->input('keyword', '');  // デフォルト値として空の文字列を設定
        $query = $user->posts()->orderBy('id', 'desc');

        if (!empty($keyword)) {
            $keywords = mb_split('\s+', $keyword);  // マルチバイト文字の空白文字でキーワードを分割
            Log::info('Search keywords: ', $keywords); // ログ出力
            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $word) {
                    $q->orwhere('content', 'LIKE', "%{$word}%");
                }
            });
        }

        $posts = $query->paginate(10);
        $counts = UserService::userCounts($user); // Userモデルの投稿数、フォロー数、フォロワー数を取得

        return view('users.show', compact('user', 'posts', 'counts', 'keyword'));
    }

    // ユーザがフォローしている他のユーザ一覧を表示
    public function followings($id)
    {
        $user = User::findOrFail($id);
        $users = $user->followings()->orderBy('created_at', 'desc')->paginate(10);
        $counts = UserService::userCounts($user); // Userモデルの投稿数、フォロー数、フォロワー数を取得

        return view('follow.follow_list', compact('user', 'users', 'counts'));
    }

    // フォロワー一覧を表示
    public function followers($id)
    {
        $user = User::findOrFail($id);
        $users = $user->followers()->orderBy('created_at', 'desc')->paginate(10);
        $counts = UserService::userCounts($user); // Userモデルの投稿数、フォロー数、フォロワー数を取得

        return view('follow.follow_list', compact('user', 'users', 'counts'));
    }

    // ユーザ編集画面
    public function edit($id)
    {
        $user = User::findOrFail($id);

        // ユーザが認証しており、且つ認証しているユーザのidとリクエストのidが一致している場合、ユーザ編集画面を表示
        if (\Auth::check() && \Auth::id() == $id) {
            return view('users.edit', ['user' => $user]);
        }

        abort(404); // デモ画面は、ログイン画面に遷移させていたが、挙動がうまくいかなかったため、404エラーを返すように実装
    }

    // ユーザ更新処理
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('users.show', ['id' => $user->id]);
    }

    // ユーザ削除
    protected function destroy($id)
    {
        // 指定されたユーザIDを取得
        $user = User::findOrFail($id);

        // ログインユーザのIDと指定されたIDが一致する場合のみユーザを削除
        if (\Auth::id() === $user->id) {
            $user->delete(); // ユーザを削除
            return redirect()->route('top')->with('success', '退会処理が完了しました'); // 一覧画面へリダイレクト
        } else {
            // ユーザ削除の条件を満たしていない場合はエラーメッセージを表示
            return back()->with('error', 'ユーザの削除は許可されていません');
        }
    }
}
