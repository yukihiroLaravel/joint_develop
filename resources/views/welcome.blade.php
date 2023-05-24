@extends('layouts.app')
@section('content')
<div class="center jumbotron bg-info">
    <div class="text-center text-white mt-2 pt-1">
        <h1><i class="pr-3"></i>Topic Posts</h1>
    </div>
</div>
<h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>

<!-- 仮編集ボタン -->
@if (Auth::check())
<div class="card-body">
    <img class="rounded-circle img-fluid" src="" alt="">
        <div class="mt-3">
            <a href="{{ route('edit', \Auth::user()->id) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
        </div>
</div>
@else
@endif
<!-- 仮編集ボタンここまで -->

@endsection
