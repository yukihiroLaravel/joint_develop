@extends('layouts.app')
@section('content')
@include('components.flash_message')
<div class="row">
    <aside class="col-sm-4 mb-5">
        <div class="card bg-info" style="min-height: 400px;">
            <div class="card-header">
                <h3 class="card-title text-light">{{$user->name}}</h3>
                @include('follow.follow_button', ['user' => $user])
            </div>
            <div class="card-body text-center px-4 py-0">
                <img class="rounded-circle my-5" src="{{ $user->avatar_image_url }}" style="width: 100%; max-width: 250px; aspect-ratio: 1/1; object-fit: cover;" alt="ユーザのアバター画像">

                @if (Auth::check() && Auth::id() === $user->id)
                    {{-- アイコン編集リンク --}}
                    <div>
                        <a href="{{ route('user.avatar.edit', $user->id) }}" class="text-light custom-underline">アイコンを変更する</a>
                    </div>

                    {{-- ユーザ情報の編集ボタン（本人だけに表示） --}}
                    <div class="my-3">
                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                    </div>
                @endif
            </div>
        </div>
    </aside>
    <div class="col-sm-8">
        <ul class="nav nav-tabs nav-justified mb-3">
            <li class="nav-item"><a href="{{ route('user.show', $user->id) }}" class="nav-link {{ Request::is('users/'. $user->id) ? 'active' : '' }}">タイムライン</a></li>
            <li class="nav-item"><a href="{{ route('user.follows', $user->id) }}" class="nav-link {{ Request::is('users/'. $user->id. '/follows') ? 'active' : '' }}">フォロー中 <div class="badge badge-secondary">{{ $countFollows }}</div></a></li>
            <li class="nav-item"><a href="{{ route('user.followers', $user->id) }}" class="nav-link {{ Request::is('users/'. $user->id. '/followers') ? 'active' : '' }}">フォロワー <div class="badge badge-secondary">{{ $countFollowers }}</div></a></li>
        </ul>
        {{-- 各タブの表示内容 --}}
        @if (Request::is('users/'. $user->id))
            @include('posts.posts', ['posts' => $posts])
        @else
            {{-- フォローフォロワーの一覧表示 --}}
            <div class="d-flex flex-column align-items-center">
                @foreach ($followers as $follower)
                    <div class="d-flex justify-content-center w-100">
                        <div class="card mb-3 p-3" style="max-width: 400px; width: 100%;">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle mr-3" src="{{ $follower->avatar_image_url }}" width="50" height="50" style="object-fit: cover;" alt="アイコン">
                                    <div>
                                        <h5 class="mb-0">
                                            <a href="{{ route('user.show', $follower->id) }}">{{ $follower->name }}</a>
                                        </h5>
                                    </div>
                                </div>

                                @if (Auth::check() && Auth::id() !== $follower->id)
                                    <div>
                                        @include('follow.follow_button', ['user' => $follower])
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection