@extends('layouts.app')

@section('content')
@include('replies.partials_show', ['post' => $post, 'replyId' => $replyId])
    <div class="container">
        <form method="post" action="{{ route('replies.update', ['postId' => $postId, 'replyId' => $replyId]) }}">
            @csrf
            @method('put')
            <div class="form-group">
                <label for="content">リプライ編集</label>
                <textarea name="content" id="content" class="form-control" rows="4" required>{{  old('content', $reply->content) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary float-right">更新</button>
        </form>
    </div>
@endsection