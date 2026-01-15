@extends('layouts.app')
@section('content')
    <div class="center jumbotron bg-info">
        <div class="text-center text-white mt-2 pt-1">
            <h1><i class="fas fa-desktop"></i> Cチームエンジニア日報</h1>
        </div>
    </div>
    <h5 class="text-center mb-3">参考になるもの、ためになるもの等について140字以内で共有しましょう！</h5>
    @if (Auth::check())
        <div class="text-center mb-3">
            <div class="w-75 m-auto">
            @include('commons.error_messages')
            </div>
            <form method="POST" action="{{ route('post.store') }}" class="d-inline-block w-75" enctype="multipart/form-data" >
                @csrf
                <div class="form-group">
                    <textarea class="form-control" name="content" rows="4">{{ old('content') }}</textarea>
                    <div class="text-left mt-3">
                    <input type="file" name="image">
                    </div>
                    <div class="text-left mt-3">
                        <button type="submit" class="btn btn-primary">投稿する</button>
                    </div>
                </div>
            </form>
        </div>
    @endif
    <ul class="list-unstyled">
        @include('posts.post', ['posts' => $posts])
    </ul>
@endsection
