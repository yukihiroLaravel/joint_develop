<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * 「ユーザ詳細への初期遷移、および、タイムライン」の表示
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        $posts = $this->postsByUser($user);
        $data = [
            'user' => $user,
            'posts' => $posts,
        ];
        $data += $this->userCounts($user);

        session()->forget('loginUserFollowingsContext');
        return view('users.show', $data);
    }

    /**
     * 「フォロー中」の表示
     */
    public function followings($id)
    {
        // *******************
        // 調整ロジック
        // *******************
        // 「return back()」時に$idが数字の文字列になってしまい
        // 後続処理に影響あったため、それを調整
        $id = (int)$id;
        // *******************

        $user = User::findOrFail($id);
        $followings = $user->followings()->paginate(10);
        $data = [
            'user' => $user,
            'followings' => $followings,
        ];
        $data += $this->userCounts($user);
        
        if(\Auth::id() === $id) {
            // ログインユーザが、自分についてのユーザ詳細画面で「フォロー中」を表示時に、
            // 「フォロー中」のユーザを「フォロー解除」し表示更新すると、
            // 「フォロー解除」したユーザが「フォロー中」から消える。
            // ページャー制御での同一ページ内に居残った状況で、
            // フォロー解除した人に再度、フォローするなどができる状況としたい
            // そのための特別対応処理である。
            // ページャーの同一ページ内に居残った状況中は、
            // そのページで最初に表示されたリストを、並び順も維持して
            // 表示しつづけたい。その特別対応である。

            // FollowsController.phpで「フォロー／フォロー解除」時に、
            // 「return back()」時に、flashでのセッション値の
            // followsOperationBackの値があれば、
            // 「フォロー／フォロー解除をした結果の表示更新のケース」である場合
            // followsOperationBackの値がnullであれば、
            // 「フォロー／フォロー解除をした結果の表示更新のケース」でない場合

            $isFollowsOperationBack = session('followsOperationBack');
            if(is_null($isFollowsOperationBack)) {

                // $isFollowsOperationBackがnullで、
                // 「フォロー／フォロー解除をした結果の表示更新のケース」でない場合
                // つまり、
                // 「フォロー中」タブ切替時や、その中でのページャーのページ移動時
                
                // **************************************************
                // セッション値を作る
                // **************************************************
                // シリアライズ／デシリアライズしてまで大きな値をセッションに記憶するのを避けたいため
                // $followings の並び順を維持した形でのidの配列を取得しそれを記憶させる
                $followingIds = $followings->pluck('id');
                $loginUserFollowingsContext = new \ArrayObject([
                    // 初期でのフォロー中の現在ページでのidのリスト
                    // 初期での表示順維持、なぜなら、フォロー解除、フォローを繰り返し時
                    // followsのid値が変わって作り直され、DB値の正直ベースだと
                    // たとえ、復元に成功しても並び順が変わってしまうため
                    // 初期の並び順を記憶したうえでの制御が必要だから。
                    "followingIds" => $followingIds,
                ], \ArrayObject::ARRAY_AS_PROPS);

                session(['loginUserFollowingsContext' => $loginUserFollowingsContext]);
                // **************************************************
            }
        } else {
            session()->forget('loginUserFollowingsContext');
        }
        return view('users.show', $data);
    }

    /**
     * 「フォロワー」の表示
     */
    public function followers($id)
    {
        $user = User::findOrFail($id);
        $followers = $user->followers()->paginate(10);
        $data = [
            'user' => $user,
            'followers' => $followers,
        ];
        $data += $this->userCounts($user);
        
        session()->forget('loginUserFollowingsContext');
        return view('users.show', $data);
    }

    /**
     *  削除
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        \DB::transaction(function () use ($user) {
            $user->delete();
        });

        return redirect('/');
    }
}
