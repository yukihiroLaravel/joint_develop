@extends('layouts.app')
@section('content')
    <h2 class="mt-5">投稿を編集する</h2>
    @include('commons.error_messages')
    <form method="POST" action="{{ route('post.update', $post->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
        <div class="form-group">
            <textarea id="content" class="form-control" name="content" rows="5">{{ old('content', $post->content) }}</textarea>
        </div>
        <!-- 画像を選択していれば、画像が表示される -->
        @if ($post->image !== null)
            <img class="mb-3" src="{{ Storage::url($post->image) }}" alt="画像投稿" style="display: block;">
        @endif
        <button type="submit" class="btn btn-primary" class="pt-3">更新する</button>
        <input class="ml-3" type="file" name="image">
    </form>
@endsection