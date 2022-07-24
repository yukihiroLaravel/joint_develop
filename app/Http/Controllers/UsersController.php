<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditRequest;
class UsersController extends Controller
{
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', [
            'user' => $user
        ]);
    }

    public function update(EditRequest $request, $id)
    {
        
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        
        //新規パスワードの確認
        
        $password = $user->password;
        $hash = password_hash($password, PASSWORD_DEFAULT);
        if(password_verify($password, $hash)){
            echo "パスワードを変更しました。";
        }

        
        $user->save();
        return back();
        // return view('users'.{$id})
        // return redirect ('/');
        // ->with('success','パスワードの変更が終了しました');
    }
    
}
