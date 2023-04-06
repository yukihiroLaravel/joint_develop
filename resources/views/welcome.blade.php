@extends('layouts.app')
@section('content')
<div class="center jumbotron bg-info ">
    <div class="text-center text-white mt-2 pt-1">
        <h1><i class="fas fa-chalkboard-teacher pr-3 d-inline"></i>Topic Posts</h1>
    </div>
</div>
<h5 class="description text-center">"○○"について140字以内で会話しよう！</h5>
@include('post.post',['posts' => $posts])
<!-- @include('post.post') -->
@endsection