@extends('layouts.app')
@section('content')
    <h2 class="mt-5">投稿を編集する</h2>
    <form method="post" action="{{ route('posts.update', $post->id) }}">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <textarea id="content" class="form-control" name="content" rows="5">{{ $post->content }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">更新する</button>
    </form>
@endsection
