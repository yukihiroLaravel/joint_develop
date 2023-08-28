@extends('layouts.app')
@section('content')
    @if (session('messageSuccess'))
        <div class="flash_message alert alert-success text-center">
            {{ session('messageSuccess') }}
        </div>
    @endif
    @include('commons.error_messages')
    <p class="mb-2">{{ $post->text }}</p>
    <h2 class="mt-3">コメントする</h2>
    <form method="POST" action="{{ route('comment.store') }}">
        @csrf
        <input type="hidden" name='post_id' value="{{$post->id}}">
        <div class="form-group">
            <textarea id="content" class="form-control" name="content" rows="6"></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-2 mb-3">コメントする</button>
    </form>
    @foreach ($post->comments as $comment)
        @if (isset($comment->content))
            <p class="">{{ $comment->content }}</p>
        @endif
    @endforeach
@endsection