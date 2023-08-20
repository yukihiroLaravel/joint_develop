@extends('layouts.app')
@section('content')

<div class="center jumbotron bg-info">
    <div class="text-center text-white mt-2 pt-1">
         <h1><i class="fab fa-telegram pr-2000 d-inline"></i>Topic Posts</h1>
    </div>
</div>
<h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>
@include('posts.posts', ['posts' => $posts])   
@endsection

