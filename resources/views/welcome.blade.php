@extends('layouts.app')
@section('content')
<!-- <div class="center jumbotron bg-info">
    <div class="text-center text-white mt-2 pt-1">
        <h1><i class="pr-3 "></i>Topic Posts</h1><i class="fa-solid fa-paper-plane"></i>
    </div>
</div> -->

<h4 class="text-center">地域の選択</h4>
    <div class="map_sea">
    <div class="map-container">
        <a href="九州のリンク" class="region-box" style="top: 50%; left: 20%; height: 140px">
            九州
        </a>
        <a href="四国・中国のリンク" class="region-box" style="top: 40%; left: 28%; width:150px">
            中国・四国
        </a>
        <a href="四国・中国のリンク" class="region-box" style="top: 52%; left: 31%; width:100px; height:75px">
            
        </a>
        <a href="近畿・東海のリンク" class="region-box" style="top: 40%; left: 42%; height: 160px">
            近畿・東海
        </a>
        <a href="東北・関東のリンク" class="region-box l-box" style="top: 20%; left: 70%;">
            東北・関東
        </a>
        <a href="北海道のリンク" class="region-box" style="top: 10%; left: 90%;">
            北海道
        </a>
    </div>
    </div>

    <h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>
    @if (Auth::check())
        <div class="w-75 m-auto">
            @include('commons.error_messages')</div> 
        <div class="text-center mb-3">
            <form method="POST" action="{{ route('post.store') }}" class="d-inline-block w-75">
            @csrf
                <div class="form-group">
                    <textarea class="form-control" name="content" rows="4">{{ old('content') }}</textarea>
                    <div class="text-left mt-3">
                        <button type="submit" class="btn btn-primary">投稿する</button>
                    </div>
                </div>
            </form>
        </div>
    @endif  
@endsection
 