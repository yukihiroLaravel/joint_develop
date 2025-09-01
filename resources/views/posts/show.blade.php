@extends('layouts.app')
@section('content')
@include('commons.success_messages')

<div class="container w-75">
    {{-- 投稿内容 --}}
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex align-items-center mb-2">
                <a href="{{ route('users.show', $post->user->id) }}">
                    <img src="{{ Gravatar::src($post->user->email, 50) }}" class="rounded-circle mr-2">
                </a>
                <strong>{{ $post->user->name }}</strong>
            </div>
            <p>{{ $post->content }}</p>
            @if ($post->images->isNotEmpty())
                <div class="mb-2">
                    @foreach ($post->images as $image)
                        <img src="{{ asset('storage/' . $image->file_path) }}" alt="{{ $image->file_name }}" style="max-width:200px; margin:5px;">
                    @endforeach
                </div>
            @endif
            <p class="text-muted">{{ $post->created_at }}</p>
        </div>
    </div>
    {{-- 返信一覧 --}}
    <h5>返信一覧</h5>
    <ul class="list-unstyled">
        @forelse ($replies as $reply)
            <li class="border p-2 rounded mb-2">
                <div class="d-flex align-items-center mb-1">
                    <a href="{{ route('users.show', $reply->user->id) }}">
                        <img src="{{ Gravatar::src($reply->user->email, 40) }}" class="rounded-circle mr-2">
                    </a>
                    <strong>{{ $reply->user->name }}</strong>
                    <span class="text-muted small ml-2">{{ $reply->created_at->diffForHumans() }}</span>
                </div>
                <p class="mb-1">{{ $reply->content }}</p>
                @if (Auth::id() === $reply->user_id)
                    <form action="{{ route('replies.destroy', $reply->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">削除</button>
                    </form>
                @endif
            </li>
        @empty
            <p>返信はまだありません。</p>
        @endforelse
    </ul>
    {{-- 返信フォーム --}}
    @if(Auth::check())
        <form action="{{ route('replies.store', $post->id) }}" method="POST" class="mt-3">
            @csrf
            <div class="form-group">
                <textarea name="content" rows="2" 
                        class="form-control @error('content','reply_'.$post->id) is-invalid @enderror"
                        placeholder="返信を書く">{{ old('content') }}</textarea>
                @error('content','reply_'.$post->id)
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-secondary">返信する</button>
        </form>
    @endif
</div>
@endsection
