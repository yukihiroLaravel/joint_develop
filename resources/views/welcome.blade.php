@extends('layouts.app')
@section('content')
<div class="center jumbotron bg-info">
    <div class="text-center text-white mt-2 pt-1">
        <h1><i class="pr-3"></i>Topic Posts</h1>
    </div>
</div>    
<h5 class="text-center mb-3">"○○"について140字以内で会話しよう!</h5> 
    @include('commons.error_messages')
    <div class="text-center mb-3">
        <form method="POST" action="{{ route('posts.store') }}" class="d-inline-block w-75">
        {{-- フラッシュメッセージ --}}
            @if (session('successMessage'))
                <div class="alert alert-success text-center">
                    {{ session('successMessage') }}
                </div>
            @endif
        {{-- フラッシュメッセージ終わり --}}   
            @csrf
            @include('commons.error_messages')
            <div class="form-group">
                @if(Auth::check())
                    <textarea class="form-control" name="content" rows="5"></textarea>
                    <div class="text-left mt-3">
                    <button type="submit" class="btn btn-primary">投稿する</button>
                    </div>
                @endif
            </div>
        </form>
    </div>
    @include( 'posts.posts',['posts' => $posts])
@endsection

   