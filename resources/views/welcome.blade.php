@extends('layouts.app')
@section('content')
    <div class="center jumbotron bg-info">
            <div class="text-center text-white mt-0 pt-5">
            <!-- <div class="text-center text-white mt-2 pt-5 bg-overlay"> -->
            <!-- <h1><i class="fas fa-chalkboard-teacher pr-3 d-inline"></i> -->
            <h1><img src ="{{ asset('images/tokyo-DeafLympic2025_Emblem.jpg')}}"
            alt = "デフリンピック エンブレム"
            class = "mx-2 align-middle"
            style = "height: 120px;"></h1>
            <h1>TOKYO 2025 デフリンピック</h1>
            <h1>×</h1>
            <h1>コミュニケーション</h1>
        </div>
    </div>
    <h5 class="description text-center ">デフアスリートへの応援メッセージを投稿し、自由にシェアしよう!</h5>
@endsection
