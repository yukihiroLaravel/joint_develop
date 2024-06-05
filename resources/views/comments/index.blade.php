@extends('layouts.app')

@section('content')
<div class="container">
    <h2>コメント一覧</h2>

    <!-- 成功メッセージの表示 -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('greenMessage') }}
    </div>
    @endif

    <!-- エラーメッセージの表示 -->
    @if($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
        @endforeach
    </div>
    @endif

    <!-- コメント一覧 -->
    @foreach ($comments as $comment)
    <div class="comment">
        <p>{{ $comment->content }}</p>
        <p>by {{ $comment->user->name }} at {{ $comment->created_at }}</p>
        @if(auth()->id() === $comment->user_id)
        <a href="{{ route('comments.edit', $id) }}">編集</a>
        <form method="POST" action="{{ route('comments.delete', $id) }}" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">削除</button>
        </form>
        @endif
    </div>
    @endforeach
</div>
@endsection