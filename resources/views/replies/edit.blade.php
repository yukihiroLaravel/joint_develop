@extends('layouts.app')
@section('content')
@include('replies.partials_show', ['post' => $post, 'replyId' => $replyId])
<div class="text-center mb-3">
    <div class="w-75 m-auto">
        @include('commons.error_messages')
    </div>
    <form method="post" action="{{ route('replies.update', ['postId' => $postId, 'replyId' => $replyId]) }}" class="d-inline-block w-75">
        @csrf
        @method('PUT')
        <div class="form-group text-left ">
            <label for="content">リプライ編集</label>
            <textarea name="content" id="content" class="form-control" rows="4" required>{{  old('content', $reply->content) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary float-right">更新</button>
    </form>
</div>
@endsection