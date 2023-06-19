@extends('layouts.app')
@section('content')
    <div class="center jumbotron bg-info">
        <div class="text-center text-white mt-2 pt-1">
            <h1><i class="pr-3"></i>Topic Posts</h1>
        </div>
    </div>
@include('commons.flash_message')
<h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>
<div class="w-75 mx-auto mb-4">
    <form action="{{ route('search')}}" method="GET">
        <div class="input-group">
            <input type="text" name="keywords" value="{{ old('keywords') }}" class="form-control input-group-prepend" placeholder="検索キーワード">
            <span class="input-group-btn input-group-append">
                <button type="submit" class="btn btn-primary">検索</button>
            </span>
        </div>
    </form>
</div>
@include('commons.new_post')
@include('posts.posts')
@endsection
