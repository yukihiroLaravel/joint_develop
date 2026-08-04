<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminUserRequest;
use App\User;
use App\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        $admins = User::where('is_admin', true)
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(AdminUserRequest $request)
    {
        $admin = new User();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->is_admin = true;
        $admin->save();

        return redirect()->route('admin.admins.index');
    }

    public function edit($id)
    {
        $admin = User::where('is_admin', true)->findOrFail($id);

        return view('admin.admins.edit', compact('admin'));
    }

    public function update(AdminUserRequest $request, $id)
    {
        $admin = User::where('is_admin', true)->findOrFail($id);

        $admin->name = $request->name;
        $admin->email = $request->email;

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('admin.admins.index');
    }

    public function revoke($id)
    {
        $admin = User::where('is_admin', true)->findOrFail($id);

        if (Auth::id() === $admin->id) {
            abort(403);
        }

        if (User::where('is_admin', true)->count() <= 1) {
            abort(403);
        }

        $admin->is_admin = false;
        $admin->save();

        return redirect()->route('admin.admins.index');
    }
    
    public function forceDelete($id)
    {
        $admin = User::where('is_admin', true)->findOrFail($id);

        if (Auth::id() === $admin->id) {
            abort(403);
        }

        if (User::where('is_admin', true)->count() <= 1) {
            abort(403);
        }

        $posts = Post::withTrashed()
            ->where('user_id', $admin->id)
            ->get();

        foreach ($posts as $post) {
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
        }

        if ($admin->avatar) {
            Storage::disk('public')->delete($admin->avatar);
        }

        $admin->forceDelete();

        return redirect()->route('admin.admins.index');
    }
}
