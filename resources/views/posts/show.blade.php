@extends('layouts.app')
@section('content')
@include('commons.success_messages')

<div class="container w-75">
    {{-- 投稿内容 --}}
    <div class="card mb-4 shadow" style="border: 2px solid #8b5e3c; background-color: #f9f7f1; border-radius: 15px;">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <a href="{{ route('users.show', $post->user->id) }}">
                    <img src="{{ Gravatar::src($post->user->email, 50) }}"
                        class="rounded-circle mr-2 border"
                        style="border: 2px solid #2e5c2b;">
                </a>
                <strong style="color:#2e5c2b;">{{ $post->user->name }}</strong>
            </div>
            <p class="mb-3" style="font-size:1.1em;">{{ $post->content }}</p>
            @if ($post->images->isNotEmpty())
                <div class="mb-3 d-flex flex-wrap">
                    @foreach ($post->images as $image)
                        <div class="p-2" style="background:#fff; border:1px solid #ccc; border-radius:8px; margin:5px;">
                            <img src="{{ asset('storage/' . $image->file_path) }}"
                                alt="{{ $image->file_name }}"
                                style="max-width:200px; margin:5px; border-radius:8px; box-shadow:2px 2px 6px rgba(0,0,0,0.2);">
                        </div>
                    @endforeach
                </div>
            @endif
            <p class="text-muted small"><i class="fas fa-clock"></i> {{ $post->created_at }}</p>
        </div>
    </div>
    {{-- 返信一覧 --}}
    <h5 class="mb-3" style="color:#2e5c2b; font-weight:bold;">
        <i class="fas fa-comments"></i> 返信一覧
    </h5>
    <ul class="list-unstyled">
        @forelse ($replies as $reply)
            <li class="p-3 rounded mb-3 shadow-sm"
                style="background-color:#fffdf7; border-left:5px solid #8b5e3c; border-radius:10px;">
                <div class="d-flex align-items-center mb-2">
                    <a href="{{ route('users.show', $reply->user->id) }}">
                        <img src="{{ Gravatar::src($reply->user->email, 40) }}"
                             class="rounded-circle mr-2 border"
                             style="border: 2px solid #2e5c2b;">
                    </a>
                    <strong style="color:#2e5c2b;">{{ $reply->user->name }}</strong>
                    <span class="text-muted small ml-2">{{ $reply->created_at->diffForHumans() }}</span>
                </div>
                <p class="mb-2">{{ $reply->content }}</p>
                @if (Auth::id() === $reply->user_id)
                    <form action="{{ route('replies.destroy', $reply->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                                style="border-radius:8px; font-weight:bold;">
                            <i class="fas fa-trash-alt"></i> 削除
                        </button>
                    </form>
                @endif
            </li>
        @empty
            <p class="text-muted"> まだ返信はありません。</p>
        @endforelse
    </ul>
    {{-- 返信フォーム --}}
    @if(Auth::check())
        <form action="{{ route('replies.store', $post->id) }}" method="POST" class="mt-4 p-3 rounded shadow-sm">
            @csrf
            <div class="form-group">
                <textarea name="content" rows="2" 
                        class="form-control border border-success @error('content','reply_'.$post->id) is-invalid @enderror"
                        placeholder="返信を書く">{{ old('content') }}</textarea>
                @error('content','reply_'.$post->id)
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-success shadow-sm"
                    style="border-radius:10px; font-weight:bold;">
                <i class="fas fa-paper-plane"></i> 返信する
            </button>
        </form>
    @endif
</div>
@endsection
