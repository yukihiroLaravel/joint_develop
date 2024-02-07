@extends('layouts.app')

@section('content')
<div class="row">
    <aside class="col-sm-4 mb-5">
        <div class="card bg-info">
            <div class="card-header">
                <h3 class="card-title text-light">{{ $user->name }}</h3>
            </div>
            <div class="card-body">
                <img class="rounded-circle img-fluid" src="{{ asset($user->profile_image) }}" alt="User Profile Image">
                <div class="mt-3">
                    <a href="{{ route('user.show', $user->id) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                </div>
            </div>
        </div>
    </aside>
    <div class="col-sm-8">
        <ul class="nav nav-tabs nav-justified mb-3">
            <li class="nav-item"><a href="{{ url('/timeline') }}" class="nav-link {{ Request::is('timeline') ? 'active' : '' }}">タイムライン</a></li>
            <li class="nav-item"><a href="{{ route('following') }}" class="nav-link {{ Request::is('following') ? 'active' : '' }}">フォロー中</a></li>
            <li class="nav-item"><a href="{{ route('followers') }}" class="nav-link {{ Request::is('followers') ? 'active' : '' }}">フォロワー</a></li>
        </ul>
    </div>
</div>
@endsection
