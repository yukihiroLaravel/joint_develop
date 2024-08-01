@extends('layouts.app')
@section('content')
    <h2 class="mt-5">投稿を編集する</h2>
    @include('commons.error_messages')
    <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <textarea id="content" class="form-control" name="content" rows="5">{{ old('content', $post->content) }}</textarea>
            <div class="text-left mt-3">
                <label for='image'>画像をアップロード</label>
                <input type='file' class="form-control" name="image" id="image">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">更新する</button>
    </form>
@endsection