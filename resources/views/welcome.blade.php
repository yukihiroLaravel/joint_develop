@extends('layouts.app')
@section('content')
    <div class="center jumbotron bg-info">
        <div class="text-center text-white mt-2 pt-1">
            <h1><i class="fab fa-telegram pr-2000 d-inline"></i>Topic Posts</h1>
        </div>
    </div>
    <h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>
        <form method="POST" action="{{ route('post.store') }}">
        @if(Auth::check())
            @include('commons.error_messages')            
            @if (session('successMessage'))
                 <div class="alert alert-success text-center">
                        {{ session('successMessage') }}
                </div> 
            @endif
            @csrf
            <div class="text-center mb-3">
                <div class="w-75 m-auto">
                    <div class="form-group">
                        <textarea class="form-control" name="text"  rows="4"  value="{{ old('text') }}"></textarea>
                    </div>
                </div>    
                <div class="text-left d-inline-block w-75 mb-2">
                    <button type="submit" class="btn btn-primary">投稿する</a>
                </div>
            </div>  
        </form>
        @endif
    @include('posts.posts', ['posts' => $posts]) 
@endsection

