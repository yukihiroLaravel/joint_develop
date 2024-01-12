@extends('layouts.app')
@section('content')
<h2 class="mt-5">投稿を編集する</h2>
<form method="POST" action="{{ route('posts.update', $post->id) }}"  enctype="multipart/form-data">
    @csrf
    @include("commons.error_messages")
    @method('PUT')
    <div class="form-group mt-5">
        <div class="form-group">
            <textarea id="content" class="form-control" name="content" rows="4">{{old("content", $post->content)}}</textarea>
        </div>
        <div class ="text-center mt-3 mb-3">
            <input type="file" name="img_path" accept=".jpg, .png">
        </div>
        <div class="text-left mb-3">
            @if(isset($post->img_path))
                <img src="{{ Storage::url($post->img_path) }}" width="25%">
            @endif
        </div>
        <button type="submit" class="btn btn-primary">更新する</button>
    </div>
</form>
@endsection