@extends('layouts.app')
@section('content')
<h2 class="mt-5">投稿を編集する</h2>
@include('commons.error_messages')

    <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data" class="w-100">
        @csrf
        @method('PUT')
        <div class="form-group">
            <textarea id="content" class="form-control" name="content" rows="">{{ old('content',$post->content) }}</textarea>   
        </div>
        @if ($post->image)
        <div class="mb-3">
            <p>現在の画像：</p>
            <img src="{{ asset('storage/' . $post->image) }}" alt="投稿画像" style="max-width: 200px;">
        </div>
        @endif
        <div class="form-group">
            <label for="image">画像を変更する</label>
            <input type="file" class="form-control-file" name="image" id="image">
        </div>
        <button type="submit" class="btn btn-primary">更新する</button>
    </form>
@endsection