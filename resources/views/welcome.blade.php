@extends('layouts.app')
@section('content')
<div class="center jumbotron bg-info ">
    <div class="text-center text-white mt-2 pt-1">
        <h1><i class="fas fa-chalkboard-teacher pr-3 d-inline"></i>Topic Posts</h1>
    </div>
</div>
@if (session('updateMessage'))
  <div class="alert alert-success text-center w-75 mx-auto">
    {{ session('updateMessage') }}
  </div> 
@endif
<h5 class="description text-center">"○○"について140字以内で会話しよう！</h5>
@if (Auth::check())
    <div class="w-75 m-auto">@include('commons.error_messages')</div>
    <div class="text-center mb-3">
        <form method="post" action="{{ route('post.store') }}" class="d-inline-block w-75">
        @csrf
            <div class="form-group">
                <textarea class="form-control" name="contents" rows="4">{{ old('contents') }}</textarea>
                <div class="text-left mt-3">
                    <button type="submit" class="btn btn-primary">投稿する</button>
                </div>
            </div>
        </form>
    </div>
@endif
@include('post.post',['posts' => $posts])
@endsection