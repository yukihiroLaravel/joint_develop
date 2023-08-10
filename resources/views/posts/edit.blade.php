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
        <button type="submit" class="btn btn-primary">更新する</button>
    </form>
@endsection