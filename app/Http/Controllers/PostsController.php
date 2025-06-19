<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Review;
use App\Http\Requests\PostRequest;
use App\Http\Requests\SearchRequest;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function index(SearchRequest $request)
    {
        $keyword = $request->input('keyword');
        $posts = Post::withCount('reviews')
            ->when($keyword, function ($query, $keyword) {
                return $query->where('content', 'like', "%{$keyword}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(9);
        foreach ($posts as $post) {
            $post->average_ratings = Review::averageRatingsForPost($post);
        }
        $data = [
            'keyword' => $keyword,
            'posts' => $posts,
        ];
        return view('welcome', $data);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        $post->load('user');
        $reviews = $post->reviews()->with('user')->orderBy('id', 'desc')->paginate(10);
        $latestReview = Review::latestReview($post);
        $hasReviewed = false;
        if (Auth::check() && Auth::id() !== $post->user_id) {
            $hasReviewed = Review::hasReviewed(Auth::user(), $post);
        }
        $averageRatings = Review::averageRatingsForPost($post);
        $data = [
            'post' => $post,
            'reviews' => $reviews,
            'latestReview' => $latestReview,
            'hasReviewed' => $hasReviewed,
            'averageRatings' => $averageRatings,
        ];
        $data += Review::reviewCounts($post);
        return view('posts.show', $data);
    }

    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->content = $request->content;
        $post->user_id = $request->user()->id;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('post_images', 'public');
            $post->image = $path;
        }
        $post->save();
        return back();
    }
    
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->deleteImage();
            $post->deleteReviews();
            $post->delete();
        }
        return redirect()->back();
    }      

    //editメソッドを作成。動画編集のあたり
    public function edit($id) //編集ボタンを押した投稿データの、idを取得
    { 
        $post = Post::findOrFail($id); //選択した投稿に該当する、投稿データを取得。
        if (\Auth::id() === $post->user_id) { //自分の投稿以外は編集できないようにする。そのために、ログインユーザのidと、投稿データのidが一致しない場合はエラーを出す。
            $data = [
                'post' => $post,
            ];
            return view('posts.edit', $data); //posts.editビューを表示
        } 
        abort(404); //404エラーを返す。
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id); //idに該当する投稿データを取得。見つからなければ404エラーを返す
        $post->content = $request->input('content'); //投稿内容をpostテーブルのcontentカラムに代入
        if ($request->hasFile('image')) {
            $post->deleteImage();
            $path = $request->file('image')->store('post_images', 'public');
            $post->image = $path;
        }
        $post->save(); //postテーブルに保存
        return redirect('/');              
    }
}