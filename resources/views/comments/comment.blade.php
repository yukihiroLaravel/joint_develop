@extends('layouts.app')
@section('content')
    <p class="mb-2">{{ $post->text }}</p>
    <h2 class="mt-5">コメントする</h2>
    @include('commons.error_messages')
    <form method="POST" action="{{ route('comment.store') }}">
        <div class="form-group">
            <textarea id="content" class="form-control" name="content" rows="6"></textarea>
        </div>
    </form>
@endsection