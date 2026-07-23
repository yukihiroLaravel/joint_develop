@extends('layouts.app')
@section('content')
<div class="row">
        <aside class="col-sm-4 mb-5">
            <!-- design-update: カード背景色を変更 -->
            <div class="card du-profile-card">
                <div class="card-header">
                    <h3 class="card-title mb-0">{{ $user->name }}</h3>
                </div>
                <div class="card-body">
                    {{-- design-update: Gravatarから、丸+頭文字のアバターに変更。Gravatar版はコメントアウトで保持 --}}
                    {{-- <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 300) }}" alt="{{ $user->name }}"> --}}
                    <span class="du-avatar-initial du-profile-avatar du-avatar-c{{ $user->id % 6 }}">{{ mb_substr($user->name, 0, 1) }}</span>
                    <!-- design-update: フォロー状態のピルをアバターの下に表示 -->
                    <div class="mt-3 text-center">
                        @include('followers.follow_button')
                    </div>
                    {{-- design-update: 「ユーザ情報の編集」は本人のみに表示（元は全員に表示されていた） --}}
                    @if (Auth::id() === $user->id)
                    <div class="mt-3">
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary du-btn-link d-block text-center">ユーザ情報の編集</a>
                    </div>
                    @endif
                </div>
            </div>
        </aside>
        <div class="col-sm-8">
            <!-- design-update: タブをボックス型からアンダーライン型に変更 -->
            <ul class="nav du-profile-tabs nav-justified mb-3">
            <!-- <ul class="nav nav-tabs nav-justified mb-3"> -->
                <li class="nav-item"><a href="{{ route('users.show', $user->id) }}" class="nav-link {{ Request::is('users/'. $user->id) ? 'active' : '' }}">タイムライン</a></li>
                <li class="nav-item"><a href="{{ route('users.followings', $user->id) }}" class="nav-link {{ Request::is('users/' . $user->id . '/followings') ? 'active' : '' }}">フォロー中</a></li>
                <li class="nav-item"><a href="{{ route('users.followers', $user->id) }}" class="nav-link {{ Request::is('users/' . $user->id . '/followers') ? 'active' : '' }}">フォロワー</a></li>
            </ul>
        @if ($tab == 'timeline')
            @include('posts.posts', ['posts' => $posts])
        @elseif ($tab == 'followings')
            @include('followers.followings', [
                'followings' => $followings,
                'emptyMessage' => 'フォロー中のユーザーはいません。'
            ])
        @elseif ($tab == 'followers')
            @include('followers.followers', [
                'followers' => $followers,
                'emptyMessage' => 'フォロワーはいません。'
            ])
        @endif
        </div>
</div>
@endsection
