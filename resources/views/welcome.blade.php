@extends('layouts.app')
@section('content')
    <div class="center jumbotron bg-info">
        <div class="text-center text-white mt-2 pt-1">
            <h1><i class="fas fa-home pr-3"></i>おうち時間の過ごし方</h1>
        </div>
    </div>
@include('commons.flash_message')
<h5 class="text-center mb-3">"快適なおうち時間"について140字以内で会話しよう！</h5>
<div class="w-75 mx-auto mb-4">
    <form action="{{ route('search')}}" method="GET">
        <div class="input-group">
            <input type="text" name="keywords" value="{{ old('keywords') }}" class="form-control input-group-prepend" placeholder="検索キーワード">
            <span class="input-group-btn input-group-append">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> 検索</button>
            </span>
        </div>
    </form>
</div>
@include('posts.new_post')
@include('posts.posts')
@endsection
