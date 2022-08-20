@extends('layouts.app')
@section('content')
<div class="row">
        <aside class="col-sm-4 mb-5">
            <div class="card bg-info">
                <div class="card-header">
                    <h3 class="card-title text-light">{{ $user->name }}</h3>
                </div>
                <div class="card-body">
                    <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 400)}}" alt="">
                        <div class="mt-3">
                            @auth
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                            @endauth
                        </div>
                </div>
            </div>
            @include('follow.follow_button',['user'=>$user])
        </aside>
        <div class="col-sm-8">
            <ul class="nav nav-tabs nav-justified mb-3">
                <li class="nav-item nav-link"><a href="{{ route('user.show', [$user->id]) }}">タイムライン</a></li>
                <li class="nav-item nav-link"><a href="#" class="nav-link">フォロー中</a></li>
                <li class="nav-item nav-link"><a href="#" class="nav-link">フォロワー</a></li>
            </ul>
        </div>
</div>
@endsection