@extends('layouts.app')
@section('content')
    <h2 class="mt-5">投稿を編集する</h2>
    <form method="POST" action="{{ route('post.update', ['id' => $post->id]) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('commons.error_messages')
        <div class="form-group">
            <textarea id="content" class="form-control" name="content" rows="5">{{ old('content', $post->content) }}</textarea>
            @if($post->image)
                <div class="mt-5">
                    <img src="{{ Storage::url($post->image) }}" alt="投稿画像" class="img-fluid">
                </div>
            @endif
            <div class="pt-3">
                <input type="file" name="image">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">更新する</button>
    </form>
@endsection 