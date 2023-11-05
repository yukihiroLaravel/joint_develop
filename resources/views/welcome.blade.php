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

    <ul id="area" class="mt-5 mb-5 border border-dark pt-2 pb-2 pr-3">
        <li><a href="{{ route('top') }}">全地域</a></li>
        <li><a href="{{ route('show_region', 'hokkaido') }}">北海道・東北</a></li>
        <li><a href="{{ route('show_region', 'kanto') }}">関東</a></li>
        <li><a href="{{ route('show_region', 'chubu') }}">中部</a></li>
        <li><a href="{{ route('show_region', 'kinki') }}">近畿</a></li>
        <li><a href="{{ route('show_region', 'chugoku_shikoku') }}">中国・四国</a></li>
        <li><a href="{{ route('show_region', 'kyushu_okinawa') }}">九州・沖縄</a></li>
    </ul> 

    @include("posts.posts")
@endsection
 