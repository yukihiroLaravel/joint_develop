<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        // if (\Auth::id() === $user->id) {
            $user->delete();
            
            return redirect('/');
    }
}
        

