@extends('layouts.app')
@section('content')
<h4 class="text-center mb-4 border border-dark p-1">地域の選択</h4>
    <div class="japan_map">
        <img src="{{ asset('img/map2.png') }}" alt="日本地図">
        <a href="{{ route('show_region', 'hokkaido') }}" class="text-decoration-none text-dark"><span class="area_btn area1" data-area="1">北海道・東北</span></a>
        <a href="{{ route('show_region', 'kanto') }}" class="text-decoration-none text-dark"><span class="area_btn area2" data-area="2">関東</span></a>
        <a href="{{ route('show_region', 'chubu') }}" class="text-decoration-none text-dark"><span class="area_btn area3" data-area="3">中部</span></a>
        <a href="{{ route('show_region', 'kinki') }}" class="text-decoration-none text-dark"><span class="area_btn area4" data-area="4">近畿</span></a>
        <a href="{{ route('show_region', 'chugoku_shikoku') }}" class="text-decoration-none text-dark"><span class="area_btn area5" data-area="5">中国・四国</span></a>
        <a href="{{ route('show_region', 'kyushu_okinawa') }}" class="text-decoration-none text-dark"><span class="area_btn area6" data-area="6">九州・沖縄</span></a>
    </div>

    <a href="{{ route('top') }}" class="allarea_back text-decoration-none"><h3 class="mt-4 mb-5 border border-dark p-3 text-center allarea">全地域</h3></a>
    
    @if ($region == 'hokkaido')
        @include('posts.posts1')
    @elseif ($region == 'kanto')
        @include('posts.posts2')
    @elseif ($region == 'chubu')
        @include('posts.posts3')
    @elseif ($region == 'kinki')
        @include('posts.posts4')
    @elseif ($region == 'chugoku_shikoku')
        @include('posts.posts5')
    @elseif ($region == 'kyushu_okinawa')
        @include('posts.posts6')
    @endif
@endsection
 