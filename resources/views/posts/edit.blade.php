@extends('layouts.app')
@section('content')
    <h2 class="mt-5">投稿を編集する</h2>
    <form method="POST" action="{{ route('post.update', ['id' => $post->id]) }}">
        @csrf
        @method('PUT')
        @include('commons.error_messages')
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="form-group">
            <textarea id="content" class="form-control" name="content" rows="5">{{ old('content', $post->content) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">更新する</button>
    </form>
@endsection 