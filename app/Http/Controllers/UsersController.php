<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class UsersController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
}
