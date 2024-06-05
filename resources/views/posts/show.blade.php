@extends('layouts.app')

@section('content')
<!-- 投稿編集後のフラッシュメッセージ -->
@if (session('redMessage'))
<div class="alert alert-danger  text-center">
    {{ session('redMessage') }}
</div>
@endif
<!-- 投稿削除後のフラッシュメッセージ -->
@if (session('greenMessage'))
<div class="alert alert-success text-center">
    {{ session('greenMessage') }}
</div>
@endif

<div class="container">
    <div class="row">
        <div class="col-5 w-75">
            <div class="text-left d-inline-block mb-2">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
                <p class="mt-3 mb-0 d-inline-block">
                    <a href="{{ route('user.show', ['id' => $post->user->id]) }}">{{ $post->user->name }}</a>
                </p>
            </div>
        </div>
        <div class="col-7 text-right">
            @include('follow.follow_button', ['user' => $post->user])
        </div>
    </div>

    <p>{{ $post->content }}</p>
    <p>by {{ $post->user->name }} at {{ $post->created_at }}</p>

    <!-- コメントセクション -->
    <h3>コメント一覧</h3>
    @foreach ($post->comments as $comment)
    <div class="comment">
        <p>{{ $comment->content }}</p>
        <p>by {{ $comment->user->name }} at {{ $comment->created_at }}</p>
        <!-- this fix -->
        @if(Auth::check() && auth()->id() === $comment->user_id)
        <a href="{{ route('comments.edit', $comment) }} " class="btn btn-primary">編集</a>
        <!-- 削除するフラッシュメッセージ -->
        <a class="btn btn-danger text-light" data-toggle="modal" data-target="#deleteConfirmModal-{{ $comment->id }}">削除する</a>
        <div class="modal fade" id="deleteConfirmModal-{{ $comment->id }}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>確認です</h4>
                    </div>
                    <div class="modal-body">
                        <label>本当に削除しますか？</label>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <form action="{{ route('comments.delete', $comment) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">削除する</button>
                        </form>
                        <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endforeach
    <!-- コメント投稿フォームへのリンク （ログインしている場合のみ表示）-->
    @if(Auth::check())
    <div class="mt-3">
        <a href="{{ route('comments.create', ['id' => $post->id]) }}" class="btn btn-primary">コメントを追加する</a>
    </div>
    @endif
</div>

@endsection