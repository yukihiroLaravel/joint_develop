@extends('layouts.app')
@section('title', '投稿編集ページ')
@section('description', '投稿した内容の編集ができます。')
@section('content')
<h2 class="mt-5">投稿を編集する</h2>
@include('commons.error_messages')
    <form method="POST" action="{{ route('post.update', $post->id) }}">
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
            <button type="submit" class="btn btn-primary"><i class="fas fa-check-square"></i> 更新する</button>
        </div>
    </form>
@endsection