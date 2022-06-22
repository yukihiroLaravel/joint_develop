@extends('layouts.app')
@section('content')
    <div class="center jumbotron bg-info">
        <div class="text-center text-white mt-2 pt-1">
            <h1><i class="fab fa-telegram fa-lg pr-3"></i>Postコミュニケーション</h1>
        </div>
    </div>
    <h5 class="text-center mb-3">みんなで140文字以内の"投稿"をシェアしよう！</h5>
    @if (Auth::check())
        @include('commons.error_messages')
        <div class="text-center mb-3">
            <form method="POST" action="{{ route('posts.store') }}" class="d-inline-block w-75">
                @csrf
                <div class="form-group">
                    <textarea class="form-control" name="content" rows="4">{{ old('content') }}</textarea>
                    <div class="text-left mt-3">
                        <button type="submit" class="btn btn-primary">投稿する</button>
                    </div>
                </div>
            </form>
        </div>
    @endif
    @include('posts.posts', ['posts' => $posts])
@endsection