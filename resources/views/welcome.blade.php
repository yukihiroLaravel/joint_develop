@extends('layouts.app')
@section('content')
    <div class="center jumbotron bg-info">
        <div class="text-center text-white mt-2 pt-1">
            <h1><img src="{{ asset('images/tokyo-DeafLympic2025_Emblem.jpg') }}"
                alt="デフリンピック エンブレム"
                class="mx-1 align-middle"
                style="height: 250px;">
            </h1>
            <h1><i class="pr-3"></i>TOKYO 2025 デフリンピック</h1>
            <h1>×</h1>
            <h1>コミュニケーション</h1>
        </div>
    </div>
    <h5 class="text-center mb-3">デフアスリートへの応援メッセージを投稿し、自由にシェアしよう！</h5>
    
    {{-- ここから 投稿一覧 --}}
        <div class="d-flex flex-column align-items-center mt-4">
            @include('posts.posts')
        </div>
@endsection
