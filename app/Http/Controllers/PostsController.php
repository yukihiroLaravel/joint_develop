<?php

// namespace App\Http\Controllers;
// use Illuminate\Http\Request;
// class PostsController extends Controller
// {
//     //
// }
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class UsersController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
}