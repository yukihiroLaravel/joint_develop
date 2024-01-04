@extends('layouts.app')
@section('content')
<h2 class="mt-5">投稿を編集する</h2>
<form method="POST" action="{{ route('post.update', $post->id) }}">
    @csrf
    @include("commons.error_messages")
    @method('PUT')
    <div class="form-group mt-5">
    <div class="form-group">
            <textarea id="content" class="form-control" name="content" rows="">{{$post->content}}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">更新する</button>
    </div>
</form>
@endsection