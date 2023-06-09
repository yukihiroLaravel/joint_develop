@extends('layouts.app')
@section('content')
@if (session('withdraw_message'))
    <div class="withdraw_message bg-danger text-center  .py-300 .my-0">
        {{ session('withdraw_message') }}
    </div>
@endif
@if (session('flash_message'))
    <div class="flash_message bg-success text-center  .py-300 .my-0">
        {{ session('flash_message') }}
    </div>
@endif
    <div class="center jumbotron bg-info">
        <div class="text-center text-white mt-2 pt-1">
            <h1><i class="pr-3"></i>Topic Posts</h1>
        </div>
    </div>
    <h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>
    <div class="w-75 m-auto">@include('commons.error_messages')</div>
    @if (Auth::check())
        <div class="text-center mb-3">
            <form method="POST" action="{{ route('post.store') }}" class="d-inline-block w-75">
                @csrf
                <div class="form-group">
                    <textarea class="form-control" name="text" rows="4">{{ old('text') }}</textarea>
                    <div class="text-left mt-3">
                        <button type="submit" class="btn btn-primary">投稿する</button>
                    </div>
                </div>
            </form>
        </div>
    @endif
    @include('posts.posts',['posts' => $posts])
@endsection

