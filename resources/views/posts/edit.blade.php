@extends('layouts.app')
@section('content')
    <h2 class="mt-5">投稿を編集する</h2>
    @include('commons.error_messages')
    <form method="POST" action="{{ route('post.update', $post->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <textarea id="content" class="form-control" name="text" rows="6">{{  old('text', $post->text) }}</textarea>
        </div>
        <div>
        @if (is_null($post->image))
            <input type="file" name="image" class="">
        @endif
        </div>
        @if (isset($post->image))
            <p class="mb-2"><img src="{{ asset($post->image) }}" width="75%" height="75%"></p>
        @endif
        <div class="d-flex justify-content-between w-75 pb-3">
            <button type="submit" class="btn btn-primary mt-3">更新する</button>
    </form>
    <form method="POST" action="{{ route('post.image_delete', $post->id) }}">
        @csrf
        @method('DELETE')
        @if (isset($post->image))
            <button type="submit" class="btn btn-success mt-3">投稿済みの画像を削除する</button>
        @endif
        </div>
    </form>
@endsection