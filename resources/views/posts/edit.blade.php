@extends('layouts.app')
@section('content') 
<h2 class="mt-5">投稿を編集する</h2>
<div class="m-auto">@include('commons.error_messages')</div>
<div class="test-center mb-3">
    <form method="POST" action="{{ route('post.update', $post->id) }}" class="d-inline-block w-75">
        @csrf
        @method('PUT')
        <div class="form-group">
            <textarea id="content" class="form-control" name="content" rows="5">{{ old('content', $post->content) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">更新する</button>
    </form>
</div> 
@endsection
