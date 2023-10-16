<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show()
    {
        $user = autn()->user();
        return view('profile', ['user' => $user]);

    }

    public function destroy(User $user)
     {
          $this->authorize('edit', $user);
          $user->delete();
          return redirect()->route('top');
     }
}
