@extends('layouts.app')
@section('content')
@if (session('flash_create_message'))
   <div class="alert alert-success">
        {{ session('flash_create_message') }}
   </div>
@elseif(session('flash_delete_message'))
    <div class="alert alert-danger">
        {{ session('flash_delete_message') }}
   </div>
@endif

<div class="center jumbotron bg-success bg-img">
    <div class="text-center text-white mt-2 pt-1 z-index20">
        <h1 class="t-text"><i class="pr-3"></i>”地元のおすすめ発信”掲示板</h1>
    </div>
</div>   
<h5 class="text-center mb-3">地元のおすすめな<br>『もの・こと・イベント』<br>について140字以内で会話しよう！</h5>
@if(Auth::check())
    <div class="w-75 m-auto">
        @include('commons.error_messages')
    </div>
    <div class="text-center mb-3">
        <form method="POST" action="{{ route('posts.store') }}" class="d-inline-block w-75">
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
@include('posts.post', ['posts' => $posts])
@endsection

                
