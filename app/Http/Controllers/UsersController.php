<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\User;

class UsersController extends Controller
{
    use SoftDeletes;

    public function index()
    {
        return view('welcome');
    }

  
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $data=[
            'user' => $user,
        ];
        return view('users.edit',$data);
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return view('users.edit'); //ユーザ詳細画面のURL
    }

}