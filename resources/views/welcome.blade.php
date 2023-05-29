@extends('layouts.app')
@section('content')
    <div class="center jumbotron bg-info">
        <div class="text-center text-white mt-2 pt-1">
            <h1><i class="fab fa-telegram fa-lg pr-3"></i>Topic Posts</h1>
        </div>
    </div>
    <h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>        
    <div class="w-75 m-auto">@include('commons.error_messages')</div>
        <div class="text-center mb-3">
            @if (Auth::check())
                <form method="POST" action="{{route('post.store')}}" class="d-inline-block w-75">
                    @csrf
                    <div class="form-group">
                        <textarea class="form-control" name="content" rows="4"></textarea>
                        <div class="text-left mt-3">
                            <button type="submit" class="btn btn-primary">投稿する</button>
                        </div>
                    </div>
                </form>
            @endif   
        </form>
        @include('posts.posts', ['posts' => $posts])
    </div>        
@endsection