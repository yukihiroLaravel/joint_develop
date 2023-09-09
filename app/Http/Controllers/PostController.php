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
     * 投稿データを論理削除。
     * @param string $id
     * @return view
     */
    public function deletePost ($id) {
        $post = Post::find($id);
        if (Auth::id() === $post->user->id) {
            try {
                $post->delete();
                return back();
            } catch (\Throwable $th) {
                abort(500);
            }
        }
        abort(404);
    }
    
}
