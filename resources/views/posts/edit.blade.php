@extends('layouts.app')
@section('content')
    <h2 class="mt-5">投稿を編集する</h2>
    @include('commons.error_messages')
    <form method="POST" action="{{ route('post.update', $post->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <textarea id="content" class="form-control" name="text" rows="6">{{  old('text', $post->text) }}</textarea>
        </div>
        @if (isset($post->image))
            <p class="mb-2"><img src="{{ asset($post->image) }}" width="800px"></p>
        @endif
        <input type="file" name="image">
            <button>アップロード</button><br>
            <button type="submit" class="btn btn-primary mt-3">更新する</button>
    </form>
@endsection