
@extends('layouts.app')
@section('content')
    <div class="center jumbotron jumbotron-extend bg-info">
        <div class="text-center text-white mt-2 pt-1">
            <h1><i class="fas fa-baseball-ball fa-lg pr-3"></i>Base Talk</h1>
        </div>    
    </div>
    <h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5> 
    @if(Auth::check())
        @include('posts.new_post')
    @endif
    <ul class="list-unstyled">
        @include('posts.post', ['posts' => $posts])
    </ul>       
    <div class="d-flex justify-content-center">
        {{ $posts->links() }}
    </div>  
@endsection
