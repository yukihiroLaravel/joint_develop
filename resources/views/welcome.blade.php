@extends('layouts.app')
@section('content')
    <div class="center jumbotron bg-info">
        <div class="text-center text-white mt-2 pt-1">
            <h1><i class="pr-3"></i>Topic Posts</h1>
        </div>
    </div>
</div>
@if (session('greenMessage'))
    <div class="alert alert-success alert-dismissible fade show mx-auto w-75" role="alert">
        <strong>{{ session('greenMessage') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
</div>
@endif
@if (session('redMessage'))
    <div class="alert alert-danger alert-dismissible fade show mx-auto w-75" role="alert">
        <strong>{{ session('redMessage') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>
@include('commons.new_post')
@include('posts.posts')
@endsection
