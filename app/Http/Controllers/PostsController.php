<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Http\Requests\PostRequest;
use App\PostImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isNull;

class PostsController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'activeList' => $request->activeList
        ];
        $posts = Post::query();
        $users = User::query();
        if (!empty($request->searchWords)) {
            $searchWords = mb_convert_kana($request->searchWords, 's');
            $arraySearchWords = preg_split('/[\s,]+/', $searchWords, -1, PREG_SPLIT_NO_EMPTY);
            $data += [
                'searchWords' => $searchWords,
                'arraySearchWords' => $arraySearchWords,
            ];
            foreach ($arraySearchWords as $searchWord) {
                $posts->orwhere('content', 'LIKE', '%' . $searchWord . '%');
                $users->orwhere('name', 'LIKE', '%' . $searchWord . '%');
            }
        }
        $posts = $posts->orderBy('id', 'desc')->paginate(10, ["*"], 'posts-page')->appends(["users-page" => $request->input('users-page')]);
        $users = $users->orderBy('id', 'desc')->paginate(10, ["*"], 'users-page')->appends(["posts-page" => $request->input('posts-page')]);
        $data += [
            'posts' => $posts,
            'users' => $users,
        ];

        return view('welcome', $data);
    }

    public function store(PostRequest $request)
    {
        $user = Auth::user();
        $post = new Post;
        $post->user_id = $user->id;
        $post->content = $request->content;
        $post->save();

        if (request()->file()) {
            $requestFiles = request()->file('postImgs');
            $this->savePostImages($requestFiles, $post->id);
        }
        return back();
    }

    public function savePostImages($requestFiles, $postId)
    {
        foreach ($requestFiles as $postFile) {
            $fileName = $postFile->store('public/images/postImgs');
            $fileName = str_replace('public/images/postImgs/', '', $fileName);
            $postImage = new PostImage;
            $postImage->post_id = $postId;
            $postImage->image_name = $fileName;
            $postImage->save();
        }
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            foreach ($post->postImages as $postImage) {
                $this->postImageDelete($postImage);
            }
            $post->delete();
        }
        return back();
    }
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            return view('posts.edit', [
                'post' => $post,
            ]);
        }
        return back();
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->content = $request->content;
            $post->save();

            $deleteImgsId = explode("/", $request->deleteImg);
            if ($deleteImgsId[0] !== "none") {
                $deletePostImgs = PostImage::where('post_id', '=', $id)->whereIn('id', $deleteImgsId)->get();
                foreach ($deletePostImgs as $deletePostImg) {
                    $this->postImageDelete($deletePostImg);
                }
            }
            if (request()->file()) {
                $requestFiles = request()->file('postImgs');
                foreach ((array)$request->exchanges as $value) {
                    $exchanges[] = explode("/", $value);
                }
                foreach ($requestFiles as $index => $postFile) {
                    if (isset($exchanges) && in_array($index, array_column($exchanges, '0'))) {
                        $exchangePostImageIndex = $exchanges[array_search($index, array_column($exchanges, '0'))][1];
                        $exchangePostImage = PostImage::where('post_id', '=', $id)->findOrFail($exchangePostImageIndex);
                        Storage::disk('public')->delete('images/postImgs/' . $exchangePostImage->image_name);
                        $fileName = $postFile->store('public/images/postImgs');
                        $fileName = str_replace('public/images/postImgs/', '', $fileName);
                        $exchangePostImage->image_name = $fileName;
                        $exchangePostImage->save();
                    } else {
                        $fileName = $postFile->store('public/images/postImgs');
                        $fileName = str_replace('public/images/postImgs/', '', $fileName);
                        $postImage = new PostImage;
                        $postImage->post_id = $id;
                        $postImage->image_name = $fileName;
                        $postImage->save();
                    }
                }
            }
            return redirect('/');
        } else {
            return back();
        }
    }

    public function postImageDelete($postImage)
    {
        Storage::disk('public')->delete('images/postImgs/' . $postImage->image_name);
        $postImage->delete();
    }
}
