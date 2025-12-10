<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    // 編集画面
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }
    //更新
    public function update(Request $request, $id) 
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        //　パスワード更新
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'confirmed|min:6'
            ]);
            $user->password = bcrypt($request->password);
        }

        $user->save();
        
        return redirect()->route('user.show', $id);
        
    }

}
