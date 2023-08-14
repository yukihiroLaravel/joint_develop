<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * トップページを表示。
     * @param void
     * @return view
     */
    public function showTop () {
        $posts = Post::orderBy('created_at','desc')->paginate(10);

        return view('posts.top', ['posts' => $posts]);
    }

    public function exePost (PostRequest $request) {
        $inputs = $request->all();
        DB::BeginTransaction();
        try {
            Post::create($inputs);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            abort(500);
        }
        return redirect (route('top'));
    }
}
