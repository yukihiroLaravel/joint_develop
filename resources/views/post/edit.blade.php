@extends('layouts.app')
@section('content')
<h2 class="mt-5">投稿を編集する</h2>
<form method="POST" action="{{ route('post.update', $post->id) }}">
    @csrf
    @method('PUT')
    <div class="form-group">
        @include('commons.error_messages')
        <textarea id="content" class="form-control" name="contents" rows="5" >{{ old('contents', $post->contents) }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary">更新する</button>
</form>
@endsection