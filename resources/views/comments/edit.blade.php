@extends('layouts.app')
@section('title', 'コメント編集ページ')
@section('description', 'コメントした内容の編集ができます。')
@section('content')
<h2 class="mt-5">コメントを編集する</h2>
@include('commons.error_messages')
<form method="POST" action="{{ route('comment.update', $comment->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <input value="{{ $comment->post_id }}" type="hidden" name="post_id" />
        <div class="form-group">
            <textarea id="text" class="form-control @error('comment.'. $comment->post_id) is-invalid @enderror" name="comment[{{ $comment->post_id }}]"
            rows="5">{{ old('comment.' . $comment->post_id, $comment->comment) }}</textarea>
            @error('comment.' . $comment->post_id)
            <span class="invalid-feedback text-left" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div>
        @if ($comment->img_path !== null)
            <a href="{{ Storage::url($comment->img_path) }}" data-lightbox="comment-group_{{ $comment->id }}"
                data-title="{!!nl2br(e($comment->comment))!!}">
                <img class="img-fluid mb-2" src="{{ Storage::url($comment->img_path) }}" alt="" width="40%"
                    height="auto">
            </a>
        @endif 
        <div>
            <i class="far fa-image"></i>
            <input type="file" name="img_path" placeholder="画像投稿">
        </div>
    </div>
    <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-primary mt-5"><i class="fas fa-check-square"></i> 更新する</button>
    </div>
</form>
@endsection
