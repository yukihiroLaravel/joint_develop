<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UpdateRequest;

class UsersController extends Controller
{
    // 編集画面
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }
    
    //更新
    public function update(UpdateRequest $request, $id) 
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);

        $user->name = $request->name;
        $user->email = $request->email;
        
        //　パスワード更新
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();
        
        return redirect()->route('user.show', $id);
        
    }

}
