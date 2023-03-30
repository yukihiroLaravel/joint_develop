<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function index()
    {
        return view('welcome');
    }


    public function edit()
    {
        $user = \Auth::user();
        $userName = $user->name;
        $userEmail = $user->email;
        $data=[
            'userName' => $userName,
            'userEmail' => $userEmail,
        ];
        return view('user.usersedit',$data);
    }
    public function update(UserRequest $request, $id)
    {
        // $user = User::findOrFail($id);
        $user->user_id = $request->user()->id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        return view('welcome'); //ユーザ詳細画面のURL
    }

    // public function destroy($id)
    // {
    //     $user = User::findOrFail($id);
    //     if (\Auth::id() === $user->user_id) {
    //         $user->softDeletes();
    //     }

    //     //アラートを表示させる
    //     return back();
    // }

}
