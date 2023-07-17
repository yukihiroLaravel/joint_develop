@extends('layouts.app')
@section('content')
    <div class="center jumbotron bg-warning">
        <div class="text-center text-white mt-2 pt-1">
          <h1 class="top_str"><img class="top_r_icon"src="{{ asset('img/icon.png') }}" alt="アイコン">
          Ramen<img class="top_c_icon" src="{{ asset('img/icon3.png')}}" alt="アイコン3">Tube
          <img class="top_l_icon" src="{{ asset('img/icon.png') }}" alt="アイコン"></h1>
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
                        <div class="row">
                            <div class="text-left mt-3 col-6">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-pencil-alt"></i> 投稿する
                                </button>
                                <a href="{{ route('movie.create') }}" class="btn btn-primary"> <i class="fas fa-edit"></i>動画を投稿する</a>
                            </div>                           
                        </div>       
                    </div>                   
                </form>                                           
            @endif
        </div>       
    @include('posts.posts', ['posts' => $posts])      
@endsection