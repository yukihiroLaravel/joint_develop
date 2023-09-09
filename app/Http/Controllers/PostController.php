<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

    /**
     * 新規投稿機能。
     * @param object $request
     * @return view
     */
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

    /**
     * 投稿編集画面を表示。
     * @param string $id
     * @return view
     */
    public function showEdit ($id) {
        $post = Post::findOrFail($id);
        if (Auth::id() === $post->user->id) {
            return view('posts.edit', ['post' => $post]);
        }
        abort(404);
    }

    /**
     * 投稿編集内容をDBに保存。
     * @param　 object $request
     * @param string $id
     * @return view
     */
    public function updatePost (PostRequest $request, $id) {
        $post = Post::findOrFail($id);
        if (Auth::id() === $post->user->id) {
            DB::BeginTransaction();
            try {
                $post->content = $request->content;
                $post->save();
                DB::commit();
            } catch (\Throwable $e) {
                DB::rollBack();
                abort(500);
            }
            return redirect(route('top'));
        }
        abort(404);
    }
}
