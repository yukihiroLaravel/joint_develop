<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use App\user;
use App\Post;
use Illuminate\Support\Facades\DB;
use App\FollowUser;

class UserController extends Controller
{
    /**
     * ユーザー編集フォームを表示。
     * @param string $id
     * @return view
     */
    public function showEdit ($id) {
        if (Auth::id() === (int)$id) {
            $user = User::find($id);
            return view('users.edit', ['user' => $user]);
        }else{
            abort(404);
        }
    }

    /**
     * 更新したユーザー情報をDBへ保存。
     * @param object $request
     * @return view
     */
    public function updateUser (UserRequest $request) {
        $inputs = $request->all();
        $id = $inputs['id'];
        if (Auth::id() === (int)$id) {
            DB::BeginTransaction();
            try {
                $user = User::find($id);
                $user->fill([
                    'name' => $inputs['name'],
                    'email' => $inputs['email'],
                    'password' => bcrypt($inputs['password']),
                ]);
                $user->save();
                DB::commit();
            } catch (\Throwable $e) {
                DB::rollBack();
                abort(500);
            }
            return redirect(route('users.show' ,$id));
        }
        abort(404);
    }

    /**
     * ユーザー詳細画面を表示。
     * @param string $id
     * @return view
     */
    public function showDetail ($id) {
        $user = User::find($id);
        return view('users.detail', ['user' => $user]);
    }

    /**
     * ユーザーを論理削除。
     * @param string $id
     * @return view
     */
    public function deleteUser ($id) {
        if (Auth::id() === (int)$id) {
            try {
                User::find($id)->delete();
                $follows = FollowUser::where('following_user_id', '=', $id)->get();
                foreach ($follows as $follow) {
                    FollowUser::find($follow['id'])->delete();
                }
                $follows = FollowUser::where('followed_user_id', '=', Auth::id())->get();
                foreach ($follows as $follow) {
                    FollowUser::find($follow['id'])->delete();
                }
                return redirect(route('top'));
            } catch (\Throwable $e) {
                abort(500);
            }
        }
        abort(404);
    }
}
