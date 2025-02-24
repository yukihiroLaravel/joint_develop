@extends('layouts.app')
@section('content')
    <div class="center jumbotron" style="background-color: #556B2F">
        <div class="text-center text-white mt-2 pt-1">
            <h1 style="color: #F5F5DC; font-family: 'Courier New', monospace;">
                <i class="fas fa-campground pr-2"></i>野営トーク
            </h1>
        </div>
    </div>
    <h5 class="text-center mb-3">
        <span
            style="color: #d2691e; font-size: 36px; font-weight: bold; background-color: #F5F5DC; padding: 0.2em 0.5em; border-radius: 5px; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">
            &quot;アウトドア&quot;</span>興味はあるけど<br>
        なかなか<span
            style="color: #2E8B57; background-color: #fff8dc; padding: 0.1em 0.3em; border-radius: 5px; font-weight: bold;">
            一歩が踏み出せない人</span>のための情報交換掲示板
    </h5>
    <div class="w-75 m-auto">@include('commons.error_messages')</div>
    <div class="text-center mb-3">
        <form method="POST" action="{{ route('posts.store', ['user' => Auth::id()]) }}" enctype="multipart/form-data"
            class="d-inline-block w-75">
            @csrf
            <div class="form-group">
                <textarea class="form-control" name="content" rows="3"></textarea>
                <div class="form-group mt-2">
                    <label for="image">画像を選択</label>
                    <input type="file" class="form-control-file" name="image" id="image">
                </div>
                <div class="text-left mt-3">
                    <button type="submit" class="btn btn-primary">投稿する</button>
                </div>
            </div>
        </form>
    </div>

    <!-- 投稿一覧の表示 -->
    @include('posts.posts')
@endsection("content")
