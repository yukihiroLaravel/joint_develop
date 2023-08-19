<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FollowUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FollowUserController extends Controller
{
    /**
     * ユーザーをフォローする処理。
     * @param string $id
     * @return view
     */
    public function follow($id) {
        DB::BeginTransaction();
        try {
            FollowUser::create([
                'following_user_id' => Auth::id(),
                'followed_user_id' => $id,
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500);
        }
        return redirect(route('users.show', $id));
    }

    /**
     * フォローを解除する処理。
     * @param string $id
     * @return view
     */
    public function unfollow($id) {
        try {
            $follow = FollowUser::where('following_user_id', '=', Auth::id())->where('followed_user_id', '=', $id)->first();
            $follow->delete();
            return redirect(route('users.show', $id));
        } catch (\Throwable $th) {
            abort(500);
        }
    }
}
