<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('user.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request)
    {
        $user = User::find(Auth::id());
        $currentEmail = $user->email;
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'newEmail' => ['bail', 'required', 'string', 'email:filter', 'max:255', Rule::unique('users', 'email')->whereNot('email', $currentEmail)->whereNull('deleted_at')],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name = $request->name;
        $user->email = $request->newEmail;
        $user->password = Hash::make($request->password);
        $user->save();

        return view('user.show', [
            'user' => $user,
        ]);
    }
}
