<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;

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
        /*
            「return back()」時に$idが数字の文字列になってしまい
            後続処理に影響あったため、数値型に戻す調整
        */
        $id = (int)$id;

        $user = User::findOrFail($id);
        $followings = $user->followings()->paginate(10);
        $data = [
            'user' => $user,
            'followings' => $followings,
        ];
        $data += $this->userCounts($user);
        
        if(\Auth::id() === $id) {
            /*
                下記の特別対応のためのケースである。

                ログインユーザが、自分についてのユーザ詳細画面で「フォロー中」を表示時に、
                「フォロー中」のユーザを「フォロー解除」し表示更新すると、
                「フォロー解除」したユーザが「フォロー中」から消えてしまうのを防ぎたい。
                ( この現象は、このケースしか理屈上発生しません。)

                ログインユーザが、自分についてのユーザ詳細画面で「フォロー中」を表示時に、
                ページャーの同一ページ内に居残った状況中は、
                そのページで最初に表示されたリストを、並び順も維持して
                表示しつづけたい。その特別対応である。

                urlだけでは、
                a) 「「フォロー中」へのタブ切替時、または、ページャーでのページ切り替え時」の場合
                b) 「フォロー／フォロー解除時の表示更新」の場合
                上記の、a)、b)を判定できない。
                当ロジックは上記の、a)、b)の2パターンを通る。

                FollowsController.phpで「フォロー／フォロー解除」時に、
                「return back()」にて、flashでのセッション値に指定しているので、
                その値が無い場合は、a)であると判定できる。

                a)、b)ともに、view側は同一の特別対応の表示処理を使う。
                a) の時に、DB値の$followingsに基づき
                並び順も意識した形でのidの配列をセッションに記憶しておき
                a)、b)ともに、その配列からの復元でリスト表示し、
                ページャーの同一ページ内に居残った状況中は、
                そのページで最初に表示されたリストを、並び順も維持して
                表示しつづけながら、フォロー、フォロー解除を繰り返し可能な状況とする
            */
            $followsOperationBack = session('followsOperationBack');
            if(is_null($followsOperationBack)) {

                // $followsOperationBackがnullで、
                // 上述の「a) 「「フォロー中」へのタブ切替時、または、ページャーでのページ切り替え時」の場合」

                /*
                    セッション値を作る

                    大きな値をセッションに記憶するのを避けたいため
                    $followings の並び順を維持した形でのidの配列を取得しそれを記憶させる。
                    並び順を維持しての復元の元、フォロー、フォロー解除を繰り返し可能な状況とするため
                */
                $followingIds = $followings->pluck('id');
                $loginUserFollowingsContext = new \ArrayObject([
                    "followingIds" => $followingIds,
                ], \ArrayObject::ARRAY_AS_PROPS);

                session(['loginUserFollowingsContext' => $loginUserFollowingsContext]);
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

        $this->validateOwnership($user->id);

        \DB::transaction(function () use ($user) {
            $user->delete();
        });
        $this->showFlashSuccess("退会しました。");

        return redirect('/');
    }

    //編集
    public function edit($id)
    {
        $user = User::findOrFail($id);
        if (\Auth::user()->id !== $user->id) {
            abort(403);
        }
        return view('users.edit',['user'=>$user,]);
    }
    
    //更新
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if($request->filled('password')){
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();
        $this->showFlashSuccess("更新しました。");
        return back()->with([
            'toggleOnOff' => $request->toggleOnOff,
        ]);
    }
}
