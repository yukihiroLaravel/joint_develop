@extends('layouts.app')
@section('content')
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
<p>{{ $post->created_at }}</p>

<div class="container">
    <!-- <h2>コメントを投稿する</h2> -->

    <!-- 成功メッセージの表示 -->
    @if(session('greenMessage'))
    <div class="alert alert-success text-center">
        {{ session('greenMessage') }}
    </div>
    @endif

    <!-- コメント削除メッセージの表示 -->
    @if(session('redMessage'))
    <div class="alert alert-success text-center">
        {{ session('redMessage') }}
    </div>
    @endif

    <!-- エラーメッセージの表示 -->
    @if($errors->any())
    <div class="alert alert-danger text-center">
        @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
        @endforeach
    </div>
    @endif
    <!-- コメント投稿フォーム（ログイン時のみ表示） -->
    @if(Auth::check())
    <form action="{{ route('comments.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="content">コメント</label>
            <textarea name="content" id="content" class="form-control" rows="4">{{ old('content') }}</textarea>
        </div>
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        <button type="submit" class="btn btn-primary">投稿</button>
    </form>
    @endif
</div>
<!-- コメント一覧 -->
@foreach ($comments as $comment)
<div class="comment">
    <p>{{ $comment->content }}</p>
    <p>by {{ $comment->user->name }} at {{ $comment->created_at }}</p>
    @if(Auth::check() && auth()->id() === $comment->user_id)
    <a href="{{ route('comments.edit', ['id' => $comment->id]) }}" class="btn btn-primary">編集</a>

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
                    <form action="{{ route('comments.delete', ['id' => $comment->id]) }}" method="POST">
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
@endsection