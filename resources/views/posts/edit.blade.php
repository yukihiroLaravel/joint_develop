@extends('layouts.app')
@section('content')
    <h2 class="mt-5">投稿を編集する</h2>
    <form method="POST" action="{{ route('post.update', $post->id) }}">
        @include('commons.error_messages')
        @csrf
        @method('PUT')
        <div class="form-group">
            <textarea id="content" class="form-control" name="content" rows="5" value="{{ old('content') }}">{{ $post->content }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">更新する</button>
    </form>
@endsection