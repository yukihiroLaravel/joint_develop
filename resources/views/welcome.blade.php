@extends('layouts.app')
@section('content')
    <div class="center jumbotron bg-warning">
        <div class="text-center text-white mt-2 pt-1">
        <h1><img src="{{ asset('img/icon.png') }}" alt="アイコン" width="60" height="60">理想のラーメンについて語る！<img src="{{ asset('img/icon.png') }}" alt="アイコン" width="60" height="60"></h1>
        </div>
    </div>
    @include('commons.carousel_img')
    <h5 class="text-center mb-3">"あなたの理想のラーメン"について140字以内で会話しよう！</h5>           
        <div class="w-75 m-auto">@include('commons.error_messages')</div>
        <div class="text-center mb-3">
            @include('commons.flash_message')
            @include('layouts.search_function')             
            @if (Auth::check())
                <form method="POST" action="{{route('post.store')}}" class="d-inline-block w-75">                
                    @csrf
                    <div class="form-group">                        
                        <textarea class="form-control" name="content" rows="4">{{ old('content') }}</textarea>
                        <div class="text-left mt-3">
                            <button type="submit" class="btn btn-primary">投稿する</button>
                        </div>           
                    </div>
                </form>
            @endif
        </div>       
    @include('posts.posts', ['posts' => $posts])      
@endsection