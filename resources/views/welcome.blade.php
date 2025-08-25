@extends('layouts.app')
@section('content')
@include('commons.success_messages')
    <div class="d-flex justify-content-end mb-3 pr-5">
        <form action="{{ route('posts.search') }}" method="GET" class="form-inline d-inline-block">
            <input type="text" name="keyword" class="form-control mr-2" placeholder="キーワードを入力" value="{{ request('keyword') }}">
            <button type="submit" class="btn btn-primary">検索</button>
        </form>
    </div>
    <div class="container">
        <div class="jumbotron bg-info">
            <div class="text-center text-white mt-2 pt-1">
                <h1><i class="fab fa-telegram fa-lg pr-3"></i>Topic Posts</h1>
            </div>
        </div>
    </div>
    <h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>
    @if (Auth::check())     
        <div class="w-75 m-auto">
            @include('commons.error_messages', ['errorBag' => 'post'])
        </div>
        <div class="text-center mb-3">
            <form method="POST" action="{{route('posts.store')}}" enctype="multipart/form-data" class="d-inline-block w-75">
                @csrf
                <div class="form-group">
                    <textarea
                        class="form-control @error('content', 'post') is-invalid @enderror" 
                        name="content"
                        rows="4">{{ old('content', '', 'post') }}</textarea>
                    {{-- 投稿フォームのバリデーション --}}
                    @error('content', 'post')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <input type="file" name="images[]" multiple class="form-control-file mt-2">
                    <div class="text-left mt-3">
                        <button type="submit" class="btn btn-primary">投稿する</button>
                    </div>
                </div>
            </form>
        </div>
    @endif
    @include('posts.posts', ['posts' => $posts])
@endsection