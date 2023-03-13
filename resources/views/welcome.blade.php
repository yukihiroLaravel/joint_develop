@extends('layouts.app')
@section('content')
    <div class="center jumbotron bg-info">
        <div class="text-center text-white mt-2 pt-1">
            <h1><i class="fas fa-solid fa-headphones"></i>ゲーアニ Music Board</h1>
        </div>
    </div>
    <h5 class="text-center mb-3">" ゲーム・アニメ音楽 " をオススメしよう！</h5>
    @include('users.FlashMessages')
    @if(Auth::check())
        @if (session('message'))
            <div class="w-75 m-auto">
                <div class="text-center mb-3">
                    <ul class="alert alert-danger">{{ session('message') }}</ul>
                </div>
            </div>
        @endif
        <div class="w-75 m-auto">@include('commons.error_messages')</div>
        <div class="text-center mb-3">
            <form method="POST" action="{{ route('post.store') }}" class="d-inline-block w-75">
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
@include( 'posts.posts', ['posts' => $posts])
@endsection
