@extends('layouts.app')

@section('content')

<div class="du-composer-card w-75 mx-auto mt-4">
<div class="d-flex justify-content-between align-items-start mb-3 flex-wrap">
<div class="d-flex align-items-center">
        <span
            class="du-avatar-initial du-post-avatar-lg du-post-avatar du-avatar-c{{ $post->user->id % 6 }}">{{ mb_substr($post->user->name, 0, 1) }}</span>
                <a href="{{ route('users.show', $post->user->id) }}" class="du-post-user-name">
                    {{ $post->user->name }}
                </a>
            </div>
            <span class="du-post-time">{{ $post->created_at->format('Y/m/d H:i') }}</span>
        </div>
        <hr>
        {{-- 投稿のタグ --}}
        @if ($post->tags->isNotEmpty())
        <div class="mb-2 mt-2">
            @foreach ($post->tags as $tag)
            <span class="du-post-tag-pill">#{{ $tag->type }}</span>
            @endforeach
        </div>
        @endif
        <p class="du-post-content text-break">{{ $post->content }}</p>
        @if ($post->image !== null)
        <div class="mb-2 mt-2">
            <img class="img-fluid du-post-image rounded" src="{{ asset('storage/' . $post->image) }}" alt="投稿画像">
        </div>
        @endif
        <div class="du-reaction-row pb-3">
            @include('reactions.reaction_button', ['post' => $post])
            {{-- コメントアイコン --}}
            @php
                $commentCount = $post->comments()->count();
            @endphp
            @auth
                {{-- ログイン中: コメントフォームを開閉 --}}
                <button type="button" class="btn-comment-icon" data-toggle="collapse" data-target="#comment-form"
                    aria-expanded="false" aria-controls="comment-form" aria-label="コメントする" title="コメント">
                    <span class="comment-icon"><i class="far fa-comments"></i></span>
                    <span class="comment-count">{{ $commentCount > 0 ? $commentCount : '' }}</span>
                </button>
            @else
                {{-- 未ログイン: ログイン画面へ --}}
                <a href="{{ route('login') }}" class="btn-comment-icon post-comment-link" aria-label="ログインしてコメントする" title="コメント">
                    <span class="comment-icon"><i class="far fa-comments"></i></span>
                    <span class="comment-count">{{ $commentCount > 0 ? $commentCount : '' }}</span>
                </a>
            @endauth
            @if (Auth::id() === $post->user_id)
            <div class="du-post-actions">
                <a href="{{ route('post.edit', $post->id) }}" class="du-post-action-link"><i class="fas fa-pen mr-1"></i>編集</a>
                <form method="POST" action="{{ route('post.delete', $post->id) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="du-post-action-link du-post-action-danger"><i class="fas fa-trash mr-1"></i>削除</button>
                </form>
            </div>
            @endif
        </div>
        @include('commons.error_messages')
        {{-- コメントフォーム 送信してエラーになったときだけ、開いた状態 --}}
        {{-- $errors->any()：バリデーションエラーがある --}}
        {{-- old('parent_id') === null：返信フォームから送られていない --}}
        {{-- old('edit_comment_id') === null：編集フォームから送られていない --}}
        <div class="{{ $errors->any() && old('parent_id') === null && old('edit_comment_id') === null ? 'show' : '' }} collapse"
            id="comment-form">
            @include('comments.comment_form', ['post' => $post, 'parentId' => null])
        </div>@include('comments.comments', ['post' => $post])
    </div>

@endsection
