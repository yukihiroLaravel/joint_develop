@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="mt-5">コメントを編集する</h2>
    <!-- これで文字数のバリデーション -->
    @include('commons.error_messages')
    <form action="{{ route('comments.update', $comment->id) }}" method="POST">
        @csrf
        @method('PATCH') <!-- PATCHメソッドを指定 -->
        <div class="form-group">
            <label for="content">コメント</label>
            <textarea name="content" id="content" class="form-control" rows="4" required>{{ old('content', $comment->content) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">更新</button>
    </form>
</div>
@endsection