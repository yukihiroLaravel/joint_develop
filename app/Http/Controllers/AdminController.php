<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function users()
    {
        $users = User::withTrashed()
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.users', compact('users'));
    }

    public function posts()
    {
        $posts = Post::withTrashed()
            ->with([
                'user' => function ($query) {
                    $query->withTrashed();
                },
            ])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.posts', compact('posts'));
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->is_admin) {
            abort(403);
        }

        $user->delete();

        return redirect()->route('admin.users');
    }

    public function restoreUser($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        if ($user->is_admin) {
            abort(403);
        }

        $user->restore();

        $posts = Post::onlyTrashed()
            ->where('user_id', $user->id)
            ->where('deleted_reason', Post::DELETED_REASON_ACCOUNT_WITHDRAWAL)
            ->get();

        foreach ($posts as $post) {
            $post->restore();
            $post->deleted_reason = null;
            $post->save();
        }

        return redirect()->route('admin.users');
    }

    public function destroyPost($id)
    {
        $post = Post::findOrFail($id);

        $post->deleted_reason = Post::DELETED_REASON_ADMIN_POST;
        $post->save();

        $post->delete();

        return redirect()->route('admin.posts');
    }

    public function restorePost($id)
    {
        $post = Post::onlyTrashed()
            ->where('deleted_reason', Post::DELETED_REASON_ADMIN_POST)
            ->findOrFail($id);

        $post->restore();
        $post->deleted_reason = null;
        $post->save();

        return redirect()->route('admin.posts');
    }

    public function forceDeletePost($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);

        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        $post->forceDelete();

        return redirect()->route('admin.posts');
    }

    public function forceDeleteUser($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        if ($user->is_admin) {
            abort(403);
        }

        $posts = Post::withTrashed()
            ->where('user_id', $user->id)
            ->get();

        foreach ($posts as $post) {
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
        }

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->forceDelete();

        return redirect()->route('admin.users');
    }
}