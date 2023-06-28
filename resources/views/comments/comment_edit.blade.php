@extends('layouts.app')
@section('content')
<h2 class="mt-5">回答を編集する</h2>
<form method="POST" action="{{ route('comment.update', [$posts->id, $comment->id]) }}">
    @csrf
    @method('PUT')
    <div class="form-group">
        @include('commons.error_messages')
        <textarea id="text" class="form-control" name="body" rows="5">{{ old('body', $comment->body) }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary">更新する</button>
</form>
@endsection