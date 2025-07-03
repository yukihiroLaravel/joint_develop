<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;
use App\User;
use App\Tag;


class PostsController extends Controller
{   
    public function index(Request $request)
    {
        $tab = $request->input('tab', 'all');
        $keyword = $request->input('keyword');
        $tags = Tag::all();
        $query = Post::with(['tags', 'user']);

        if ($tab === 'follows' && Auth::check()) {
            $userIds = Auth::user()->follows()->pluck('users.id')->toArray();
            $userIds[] = Auth::id();

            if (!empty($userIds)) {
                $query->whereIn('user_id', $userIds);
            } 
        }

        $posts = $query
            ->when($keyword, fn ($q) => $q->where('content', 'like', "%{$keyword}%"))
            ->orderByDesc('created_at')
            ->paginate(10);

        $rankingUsers = User::withCount('followers')->orderByDesc('followers_count')->take(10)->get();
        $favorites = User::withCount([
            'posts as likes_received_count' => function ($query) {
                $query->join('favorites', 'posts.id', '=', 'favorites.post_id');
            }
        ])->orderByDesc('likes_received_count')->take(10)->get();

        return view('welcome', compact('posts', 'keyword', 'tags', 'rankingUsers', 'tab', 'favorites'));
    }

    public function show($id)
    {
        $post = Post::with(['user', 'tags'])->findOrFail($id);
    
        $replies = $post->replies()->with('user')->orderBy('created_at', 'desc')->paginate(10);

        return view('posts.show', compact('post', 'replies'));
    }       
   
    public function edit($id)
    {  
        $user = Auth::user();
        $post = Post::findOrFail($id); 

        if (Auth::id() != $post->user_id) {
            abort(403);
        }

        $tags = Tag::all();
        $selectedTagIds = $post->tags->pluck('id')->toArray();

        $data = [            
            'post' => $post,
            'tags' => $tags,
            'selectedTagIds' => $selectedTagIds,
        ];
        return view('posts.edit', $data);
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== $request->user()->id) {
            abort(403);
        }

        $post->content = $request->content;
        $post->user_id = $request->user()->id;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $post->image_path = $path;
        }
        
        $post->save();

        $post->tags()->sync($request->input('tags', []));
        
        return redirect()->route('post.index')->with('success', '更新が完了しました！');
    }

    public function store(PostRequest $request)
    {
        $path = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public'); 
        }

        $post = new Post;
        $post->content = $request->content;
        $post->user_id = $request->user()->id;
        $post->image_path = $path;
        $post->save();

        $post->tags()->attach($request->tags); 
        
        return redirect()->route('post.index')->with('success', '投稿が完了しました！');
    }
    
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }

        return redirect()->route('post.index')->with('success', '投稿を削除しました。');
    }

    public function create()
    {
        $tags = Tag::all();
        return view('posts.form', compact('tags'));
    }

    public function destroyImage(Post $post)
    {
        // 認可（投稿者本人のみ）
        if (auth()->id() !== $post->user_id) {
            abort(403);
        }

        // ストレージに画像が存在すれば削除
        if ($post->image_path) {
            \Storage::delete('public/' . $post->image_path);
            $post->image_path = null;
            $post->save();

            return redirect()->route('post.edit', $post->id)->with('success', '画像を削除しました');
        }
    }
}