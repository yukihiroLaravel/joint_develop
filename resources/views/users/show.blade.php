@extends('layouts.app')
@section('content')
    @php
        $isActiveTimelines = Request::is('users/' . $user->id);
        $isActiveFollowings = Request::is('users/' . $user->id . '/followings');
        $isActiveFollowers = Request::is('users/' . $user->id . '/followers');
    @endphp

    <div class="row">
        <aside class="col-sm-4 mb-5">
            <div class="card bg-info">
                <div class="card-header">
                    <h3 class="card-title text-light">{{ $user->name }}</h3>
                </div>
                <div class="card-body">
                    {{-- TODO 一旦、デザイン確認のため「temporaryAvatarImage.png」をダミー表示。「アバター」画像の仕様検討必要 --}}
                    <img class="rounded-circle img-fluid" src="{{ asset('temporaryAvatarImage.png') }}" alt="">
                        <div class="mt-3">
                            <a href="" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                        </div>
                </div>
            </div>
        </aside>
        <div class="col-sm-8">
            <ul class="nav nav-tabs nav-justified mb-3">
                <li class="nav-item"><a href="{{ route('user.show', $user->id) }}" class="nav-link {{ $isActiveTimelines ? 'active' : '' }}">タイムライン</a></li>
                <li class="nav-item"><a href="{{ route('user.followings', $user->id) }}" class="nav-link {{ $isActiveFollowings ? 'active' : '' }}">フォロー中</a></li>
                <li class="nav-item"><a href="{{ route('user.followers', $user->id) }}" class="nav-link {{ $isActiveFollowers ? 'active' : '' }}">フォロワー</a></li>
            </ul>
            
            @if ($isActiveTimelines)
                @include('users.timelines', ['user' => $user, 'posts' => $posts])
            @endif

            @if ($isActiveFollowings)
                <H1>「フォロー中」まだやねん</H1>
            @endif

            @if ($isActiveFollowers)
                <H1>「フォロワー」まだやねん</H1>
            @endif

        </div>
    </div>
@endsection
