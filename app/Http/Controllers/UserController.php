<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use App\user;
use App\Post;
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
     * ユーザー新規登録画面を表示。
     * @param void
     * @return view
     */
    public function showRegistrationForm () {
        return view ('auth.register');
    }

    /**
     * DBへユーザー新規登録
     * @param object $request
     * @return view
     */
    public function register (UserRequest $request) {
        $inputs = $request->all();
            DB::BeginTransaction();
            try {
                $user = User::create([
                    'name' => $inputs['name'],
                    'email' => $inputs['email'],
                    'password' => bcrypt($inputs['password']),
                ]);
                DB::commit();
            } catch (\Throwable $e) {
                DB::rollBack();
                abort(500);
            }
            //return redirect(route('login'));
            Auth::guard()->login($user);
            return redirect (route('top'));
     * ユーザーを論理削除。
     * @param string $id
     * @return view
     */
    public function deleteUser ($id) {
        if (Auth::id() === (int)$id) {
            try {
                User::find($id)->delete();
                return redirect(route('top'));
            } catch (\Throwable $th) {
                abort(500);
            }
        }
        abort(404);
    }
}
