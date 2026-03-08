@extends('layouts.app')
@section('content')
    <div class="center jumbotron bg-info">
        <div class="text-center text-white mt-2 pt-1">
            <h1><i class="pr-3"></i>Topic Posts</h1>
        </div>
    </div>
    @if (Auth::check())
    <h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>
        @include('commons.error_messages')
        <div class="text-center mb-3">
            <form method="POST" action="{{ route('posts.store') }}" class="d-inline-block w-75">
                @csrf
                <div class="form-group">
                    <textarea class="form-control" name="content" rows="3"></textarea>
                    <div class="text-left mt-3">
                        <button type="submit" class="btn btn-primary">投稿する</button>
                    </div>
                </div>
            </form>
        </div>
    @endif     

    <h5 class="text-center mb-3">＜投稿一覧＞</h5>

    @include('posts.post')

    <div class="d-flex justify-content-center mt-4">
    {{ $posts->links() }}
    </div>

@endsection