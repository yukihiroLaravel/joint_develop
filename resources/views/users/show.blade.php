@extends('layouts.app')
@section('content')
<div class="row">
    <aside class="col-sm-4 mb-5">
        <div class="card bg-info">
            <div class="card-header">
                <h3 class="card-title text-light">{{ $user->name }}</h3>
            </div>
            <div class="card-body">
                <img class="rounded-circle img-fluid" src="{{ Gravatar::src( $user->email , 400) }}" alt="ユーザのアバター画像">
                @if (Auth::check() && Auth::id() === $user->id)
                <div class="mt-3">
                    <a href="" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                </div>
                @endif
            </div>
        </div>
    </aside>
    <div class="col-sm-8">
        <ul class="nav nav-tabs nav-justified mb-3">
            <li class="nav-item"><a href="" class=" nav-link {{ Request::is('users/'. $user->id) ? 'active' : '' }}">タイムライン</a></li>
            <li class="nav-item"><a href="#" class="nav-link">フォロー中</a></li>
            <li class="nav-item"><a href="#" class="nav-link">フォロワー</a></li>
        </ul>
        <!-- ここから投稿表示部分追加 -->
        <ul class="list-unstyled">
            @foreach ($posts as $post)
            <li class="mb-3 text-center">
                <div class="text-left d-inline-block w-75 mb-2">
                    <img class="mr-2 rounded-circle" src="{{ Gravatar::src( $user->email , 55) }}" alt="ユーザのアバター画像">
                    <p class="mt-3 mb-0 d-inline-block"><a href="">{{ $user->name }}</a></p>
                </div>
                <div class="">
                    <div class="text-left d-inline-block w-75">
                        <p class="mb-2">{{ $post->content }}</p>
                        <p class="text-muted">{{ $post->created_at }}</p>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
        {{ $posts->links('pagination::bootstrap-4') }}
        <div class="m-auto" style="width: fit-content"></div>
    </div>
</div>
@endsection