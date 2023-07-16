@extends('layouts.app')
@section('content')
    <h2 class="mt-5">投稿を編集する</h2>
    @include('commons.error_messages')
    <form method="POST" action="{{ route('post.update', $post->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <textarea id="content" class="form-control" name="content" rows="5">{{ old('content', $post->content) }}</textarea>
        </div>
        <button type="submit" class="btn btn-warning">
            <i class="fas fa-edit"></i> 更新する
        </button>
    </form>
@endsection
