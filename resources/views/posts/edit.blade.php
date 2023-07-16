@extends('layouts.app')
@section('title', '投稿編集ページ')
@section('description', '投稿した内容の編集ができます。')
@section('content')
<h2 class="mt-5">投稿を編集する</h2>
@include('commons.error_messages')
<form method="POST" action="{{ route('post.update', $post->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <div class="form-group">
            <textarea id="text" class="form-control @error('text') is-invalid @enderror" name="text"
            rows="5">{{ old('text', $post->text) }}</textarea>
            @error('text')
            <span class="invalid-feedback text-left" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div>
        @if ($post->img_path !== null)
            <a href="{{ Storage::url($post->img_path) }}" data-lightbox="post-group_{{ $post->id }}"
                data-title="{!!nl2br(e($post->text))!!}">
                <img class="img-fluid mb-2" src="{{ Storage::url($post->img_path) }}" alt="" width="40%"
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
