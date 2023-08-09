<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\user;
use App\Post;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * トップページを表示。
     * @param void
     * @return view
     */
    public function showTop () {
        $posts = Post::orderBy('created_at','desc')->paginate(10);

        return view('posts.top', ['posts' => $posts]);
    }

    /**
     * ユーザー編集フォームを表示。
     * @param $id
     * @return view
     */
    public function showUserEdit ($id) {
        if (Auth::id() === (int)$id) {
            $users = User::find($id);
            return view('posts.edit_user', ['users' => $users]);
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
        DB::BeginTransaction();
        try {
            $user = User::find($inputs['id']);
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
        return redirect(route('top'));
    }
}
