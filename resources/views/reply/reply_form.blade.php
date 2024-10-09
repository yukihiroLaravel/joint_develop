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
            <p class="post-timestamp">{{ $post->created_at->format('Y-m-d H:i') }}</p>
        </div>
    </div>

    <!-- 返信フォーム -->
    <form action="{{ route('posts.reply', ['post' => $post->id]) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="reply">返信内容</label>
            <textarea name="reply" id="reply" class="form-control" rows="5"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">返信する</button>
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
                    <p class="reply-timestamp">{{ $reply->created_at->format('Y-m-d H:i:s') }}</p>
                </div>
            </li>
        @endforeach
    </ul>
@endsection
