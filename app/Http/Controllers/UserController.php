<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use App\user;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * ユーザー編集フォームを表示。
     * @param string $id
     * @return view
     */
    public function showEdit ($id) {
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
        if (Auth::id() === (int)$inputs['id']) {
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
        }else{
            abort(404);
        }
    }
}
