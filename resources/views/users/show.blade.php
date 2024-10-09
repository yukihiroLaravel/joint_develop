@extends('layouts.app')
@section('content')
    @php
        $isActiveTimelines = Request::is('users/' . $user->id);
        $isActiveFollowings = Request::is('users/' . $user->id . '/followings');
        $isActiveFollowers = Request::is('users/' . $user->id . '/followers');

        require_once app_path('Helpers/ViewHelper.php');
        $viewHelper = \App\Helpers\ViewHelper::getInstance();

        // 「$followsParam」を作成する。
        $followsParam = $viewHelper->createFollowsParam($user);
    @endphp

    <div class="row">
        <aside class="col-sm-4 mb-5">
            <div class="card bg-info">
                <div class="card-header">

                    @if ($followsParam->isFollowerIndicatorVisible)
                        <div class="text-left d-inline-block w-75 mb-2" style="color: white;">
                            <i class="fas fa-user"></i>&nbsp;<span>フォローされています</span>
                        </div>
                    @endif
                    <h3 class="card-title text-light" title="{{ $user->name }}">
                        {{-- 「右寄せ」のために同じH3タグ内に置く必要あり--}}
                        @if ($followsParam->isFollowsBaseOk)
                            {{ $user->truncateName(5) }}

                            @include('follows.button', ['followsParam' => $followsParam])
                        @else
                            {{ $user->truncateName(9) }}
                        @endif
                    </h3>
                </div>
                <div class="card-body">
                    @include('commons.avatar', [
                        'editFlg' => 'OFF',
                        'imageSize' => '310',
                        'user' => $user,
                        'class' => 'rounded-circle img-fluid',
                    ])
                    @if (Auth::id() === $user->id)
                        <div class="mt-3">
                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                        </div>
                    @endif
                </div>
            </div>
        </aside>
        <div class="col-sm-8">
            <ul class="nav nav-tabs nav-justified mb-3">
                <li class="nav-item"><a href="{{ route('user.show', $user->id) }}" class="nav-link {{ $isActiveTimelines ? 'active' : '' }}">タイムライン<br><div class="badge badge-secondary">{{ $countPosts }}</div></a></li>
                <li class="nav-item"><a href="{{ route('user.followings', $user->id) }}" class="nav-link {{ $isActiveFollowings ? 'active' : '' }}">フォロー中<br><div class="badge badge-secondary">{{ $countFollowings }}</div></a></li>
                <li class="nav-item"><a href="{{ route('user.followers', $user->id) }}" class="nav-link {{ $isActiveFollowers ? 'active' : '' }}">フォロワー<br><div class="badge badge-secondary">{{ $countFollowers }}</div></a></li>
            </ul>
            
            @if ($isActiveTimelines)
                @include('users.timelines', ['user' => $user, 'posts' => $posts])
            @endif

            @if ($isActiveFollowings)
                @include('users.follows', ['users' => $followings])
            @endif

            @if ($isActiveFollowers)
                @include('users.follows', ['users' => $followers])
            @endif

        </div>
    </div>
@endsection
