@extends('layouts.app')
@section('content')
   <div class="center jumbotron bg-info">
        <div class="text-center text-white mt-2 pt-1">
            <h1><i class="pr-3"></i>Topic Posts</h1>
        </div>
    </div>
    <h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>
    @if ($errors->any())
    <div class="w-75 m-auto alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif



@if (Auth::check())
    <div class="text-center mb-3">
        <form method="POST" action="{{ route('posts.store', ['topic_id' => $topic->id]) }}" class="d-inline-block w-75">
            @csrf
            <div class="form-group">
                <textarea class="form-control" name="content" rows="4" maxlength="140" required></textarea>
                <small class="form-text text-muted">残り文字数: <span id="charCount">140</span></small>
                <div class="text-left mt-3">
                    <button type="submit" class="btn btn-primary">投稿する</button>
                </div>
            </div>
        </form>
    </div>
@endif
