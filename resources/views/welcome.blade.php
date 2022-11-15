@extends('layouts.app')

@section('content')
    <div class="center jumbotron bg-info">
        <div class="text-center text-white mt-2 pt-1">
            <h1><i class="pr-3"></i>Topic Posts</h1>
        </div>
    </div>
    <h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>
    @if (session('err_msg'))
        <p class="text-danger">{{ session('err_msg') }}</p>
    @endif
    @if (session('successMessage'))
        <div class="alert alert-success text-center">
            {{ session('successMessage') }}
        </div> 
    @endif
    @if(Auth::check())
        @include('posts.create')
    @endif
    @include('posts.posts',['posts' => $posts])
@endsection