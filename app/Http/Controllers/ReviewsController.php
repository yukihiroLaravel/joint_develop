<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;
use Illuminate\Support\Facades\Auth;
use App\Review;
use App\Post;

class ReviewsController extends Controller
{
    // レビュー作成
    public function store(ReviewRequest $request, $postId)
    {
        $post = Post::findOrFail($postId);
        $review = new Review();
        $review->comment = $request->comment;
        $review->rating_service = $request->input('rating_service');
        $review->rating_cost = $request->input('rating_cost');
        $review->rating_quality = $request->input('rating_quality');
        $review->user_id = Auth::id();
        $review->post_id = $post->id;
        $review->save();
        return redirect()->route('posts.show', $post);
    }

    // 編集画面
    public function edit($postId, $reviewId)
    {
        $post = Post::findOrFail($postId);
        $review = Review::findOrFail($reviewId);
        if (Auth::id() !== $review->user_id) {
            abort(403);
        }
        $data = [
            'review' => $review,
            'post' => $post,
        ];
        return view('reviews.edit', $data);
    }

    // 更新処理
    public function update(ReviewRequest $request, $postId, $reviewId)
    {
        $post = Post::findOrFail($postId);
        $review = Review::findOrFail($reviewId);
        if (Auth::id() !== $review->user_id) {
            abort(403);
        }
        $review->comment = $request->comment;
        $review->rating_service = $request->input('rating_service') !== '' ? $request->input('rating_service') : null;
        $review->rating_cost = $request->input('rating_cost') !== '' ? $request->input('rating_cost') : null;
        $review->rating_quality = $request->input('rating_quality') !== '' ? $request->input('rating_quality') : null;
        $review->save();
        return redirect()->route('posts.show', $post);
    }

    // 削除処理
    public function destroy($reviewId)
    {
        $review = Review::findOrFail($reviewId);
        if (Auth::id() !== $review->user_id) {
            abort(403);
        }
        $review->delete();
        return back();
    }
}