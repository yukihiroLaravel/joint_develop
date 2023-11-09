@extends('layouts.app')
@section('content')
    <div class="center jumbotron bg-info mt-3">
        <div class="text-center text-white mt-2 pt-1">
            <h1><i class="fab fa-telegram fa-lg pr-3"></i>オススメしたいお店を紹介しよう</h1>
        </div>
    </div>
    <h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5> 
    <div class="m-auto">@include('commons.success_messages')</div>
    @if (Auth::check()) 
    <div class="w-75 m-auto"> @include('commons.error_messages')</div>
        <div class="text-center mb-3 mt-3">
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