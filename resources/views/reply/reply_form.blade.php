@extends('layouts.app')
@section('content')
    <!-- オリジナル投稿表示 -->
    <div class="original-post user-info-post">
        <!-- アバター画像 -->
        <div class="reply-avatar">
            <img class="rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
        </div>
        <!-- ユーザ名と投稿内容 -->
        <div class="reply-content">
            <!-- ユーザ名 -->
            <p class="reply-username">
                <a href="{{ route('user.show', $post->user->id) }}">{{ $post->user->name }}</a>
            </p>
            <!-- 投稿内容 -->
            <p class="post-text">{{ $post->post }}</p>
            <!-- 投稿日時 -->
            <p class="post-timestamp">{{ $post->updated_at->format('Y-m-d H:i') }}</p>
        </div>
    </div>

    <!-- 返信フォーム -->
    <form action="{{ route('posts.reply', ['post' => $post->id]) }}" method="POST">
        @csrf
        <div class="form-group">
            @include('commons.error_messages')
            <!-- フラッシュメッセージ -->
            @if (session('success') || session('error'))
                <div class="alert {{ session('success') ? 'alert-success' : 'alert-danger' }}">
                    {{ session('success') ?? session('error') }}
                </div>
            @endif

            <label for="reply"></label>
            <textarea name="reply" id="reply" class="form-control" rows="5">{{ old('reply') }}</textarea>
        </div>
        <button onclick="event.preventDefault();history.back()" class="btn btn-secondary mr-2">戻る</button>
        <button type="submit" class="btn btn-primary comment-button">コメントする</button>
    </form>

    <!-- 返信リスト -->
    <ul class="list-unstyled reply-list">
        @foreach ($replies as $reply)
            <li class="reply-container">
                <!-- アバター画像 -->
                <div class="reply-avatar">
                    <img class="rounded-circle" src="{{ Gravatar::src($reply->user->email, 55) }}" alt="ユーザのアバター画像">
                </div>

                <!-- 返信内容 -->
                <div class="reply-content">
                    <!-- ユーザ名 -->
                    <p class="reply-username">
                        <a href="{{ route('user.show', $reply->user->id) }}">{{ $reply->user->name }}</a>
                    </p>
                    <!-- 返信内容 -->
                    <p class="reply-text">{{ $reply->reply }}</p>
                    <!-- 返信日時 -->
                    <p class="reply-timestamp">{{ $reply->updated_at->format('Y-m-d H:i:s') }}</p>
                    <!-- 返信削除ボタン（返信したユーザーのみ表示） -->
                    @if (Auth::id() === $reply->user_id)
                        <form action="{{ route('reply.delete', $reply->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">削除</button>
                        </form>
                    @endif
                </div>
            </li>
        @endforeach
    </ul>
    <div class="m-auto" style="width: fit-content">
        {{ $replies->links('pagination::bootstrap-4') }}
    </div>
    
@endsection