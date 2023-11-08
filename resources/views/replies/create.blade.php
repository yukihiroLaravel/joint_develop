@extends('layouts.app')
@section('content')
    @include('replies.partials_show', ['post' => $post])
    <div class="text-center mb-3">
    <div class="w-75 m-auto">
        @include('commons.error_messages')
    </div>
        <form method="post" action="{{ route('replies.store', $post) }}" class="d-inline-block w-75">
            @csrf
            <div class="form-group">
                <textarea name="content" id="content" class="form-control" rows="4" required placeholder="リプライを入力">{{  old('content') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary float-right">投稿</button>
        </form>
    </div>
@endsection