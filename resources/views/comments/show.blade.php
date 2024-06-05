@extends('layouts.app')
@section('content')

<h2 class="text-center mb-3">コメント</h2>
<dl class="text-center mb-3">
    <dt>ID:</dt>
    <dd>{{ $comment->id }}</dd>
    <dt>コメント内容:</dt>
    <dd>{{ $comment->content }}</dd>
</dl>

<!-- コメント投稿者のみ編集、削除できる -->
@if (Auth::id() === $comment->user_id)
<div class="d-flex justify-content-between w-75 pb-3 m-auto">
    <form method="POST" action="{{ route('comment.delete', $comment->id) }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">削除</button>
    </form>
    <a href="{{ route('comment.edit', $comment->id) }}" class="btn btn-primary">編集する</a>
</div>
@endif

</form>
</div>
@endsection