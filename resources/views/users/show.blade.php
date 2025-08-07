@extends('layouts.app')
@section('content')
@include('commons.success_messages')
    <div class="row">
        <aside class="col-sm-4 mb-5">
            <div class="card bg-info">
                <div class="card-header">
                    <h3 class="card-title text-light">{{ $user->name }}</h3>
                </div>
                <div class="card-body">
                    <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 300) }}" alt="ユーザのアバター画像">
                    @auth
                        @if (Auth::id() === $user->id)
                            <div class="mt-3">
                                <a href="{{route('users.edit', $user->id)}}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                            </div>
                        @endif
                    @endauth    
                </div>
            </div>
        </aside>
        <div class="col-sm-8">
            {{-- URLクエリパラメータからアクティブタブ取得 --}}
            @php
                $tab = request()->get('tab', 'timeline');
            @endphp
            <ul class="nav nav-tabs nav-justified mb-3">
                <li class="nav-item">
                    <a class="nav-link {{ $tab === 'timeline' ? 'active' : '' }}"
                        href="{{ route('users.show', ['id' => $user->id, 'tab' => 'timeline']) }}">
                        タイムライン<br>
                        <div class="badge badge-secondary">{{ $posts->total() }}</div>
                    </a>
                </li>
                <li class="nav-item"> 
                    <a class="nav-link {{ $tab === 'following' ? 'active' : '' }}"
                        href="{{ route('users.show', ['id' => $user->id, 'tab' => 'following']) }}">
                        フォロー中<br>
                        <div class="badge badge-secondary">{{ $followingCount }}</div>
                    </a>
                </li>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $tab === 'followers' ? 'active' : '' }}"
                    href="{{ route('users.show', ['id' => $user->id, 'tab' => 'followers']) }}">
                    フォロワー<br>
                    <div class="badge badge-secondary">{{ $followersCount }}</div>
                    </a>
                </li>
            </ul>
            {{-- タブごとの表示内容を切り替え --}}
            @if ($tab === 'timeline')
                @include('users.tabs.timeline', ['posts' => $posts])
            @elseif ($tab === 'following')
                @include('users.tabs.following', ['users' => $followingUsers])
            @elseif ($tab === 'followers')
                @include('users.tabs.followers', ['users' => $followers])
            @endif
        </div>
    </div>
@endsection
