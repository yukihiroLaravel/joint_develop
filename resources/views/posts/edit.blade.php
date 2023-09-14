@extends('layouts.layout')
@section('content')
<h2 class="mt-5">投稿を編集する</h2>
@if($errors->any())
    @include('layouts.err')
@endif
<form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="form-group">
        <textarea id="content" class="form-control" name="content" rows="4">{{ $errors->any() ? old('content') : $post->content }}</textarea>
        @include('layouts.image')
    </div>
    <button type="submit" class="btn btn-success">更新する</button>
</form>
@endsection