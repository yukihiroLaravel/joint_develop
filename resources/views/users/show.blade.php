@extends('layouts.app')

@section('content')
@include('commons.error_messages')
@if (session('status'))
    <div class="alert alert-success mt-3">
        {{ session('status') }}
    </div>
@endif
<div class="row">
    <aside class="col-sm-4 mb-5">
        <div class="card bg-info">
            @if (session('error'))
                <div class="alert alert-danger mt-3">
                    {!! session('error') !!}
                </div>
            @endif
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title text-light">{{ $user->name }}</h3>
                @if (Auth::check() && Auth::id() !== $user->id)  {{-- 自分自身でないかを確認 --}}
                    {{-- フォローボタン共通コンポーネント --}}
                    @include('commons.follow_button', ['userId' => $user->id, 'userName' => $user->name, 'buttonClass' => 'btn-secondary'])
                @elseif (!Auth::check())  {{-- ログインしていない場合 --}}
                    <a href="{{ route('login') }}" class="btn btn-primary rounded-pill">フォローする</a>
                @endif
            </div>
            <div class="card-body">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($user->email, 300) }}" alt="ユーザのアバター画像">
                @if (Auth::check() && Auth::id() === $user->id)
                    <div class="mt-3">

                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                    </div>
                    <div class="mt-3">
                        <form method="POST" action="{{ route('user.delete', $user->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-account" data-user-name="{{ $user->name }}" data-user-email="{{ $user->email }}">退会する</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </aside>
    <div class="col-sm-8">
        <ul class="nav nav-tabs nav-justified mb-3">
            <li class="nav-item">
                <a href="{{ route('user.show', $user->id ) }}" 
                    class="nav-link {{ Request::is('users/'.$user->id) ? 'active bg-primary text-white' : '' }}">タイムライン</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('user.followings', $user->id) }}" 
                    class="nav-link {{ Request::is('users/'.$user->id.'/followings') ? 'active bg-primary text-white' : '' }}">フォロー中</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('user.followers', $user->id) }}" 
                    class="nav-link {{ Request::is('users/'.$user->id.'/followers') ? 'active bg-primary text-white' : '' }}">フォロワー</a>
            </li>
        </ul>

        {{-- タイムラインの投稿一覧 --}}
        @if (Request::is('users/'.$user->id))
            <h5 class="mt-5 mb-4">最近の投稿</h5>
            @if ($posts->count() > 0)
                <div class="list-group">
                    @foreach ($posts as $post)
                        <div class="list-group-item">
                            <h6>{{ $post->created_at->format('Y/m/d H:i') }}</h6>
                            <p>{{ $post->post }}</p>
                        </div>
                    @endforeach
                </div>
                {{-- ページネーションリンク --}}
                {{ $posts->links('pagination::bootstrap-4') }}
            @else
                <p>投稿がありません。</p>
            @endif
        @endif

        {{-- フォロー中のユーザー一覧 --}}
        @if (Request::is('users/'.$user->id.'/followings'))
            @include('users.followings', ['user' => $user])
        @endif

        {{-- フォロワーのユーザー一覧 --}}
        @if (Request::is('users/'.$user->id.'/followers'))
            @include('users.followers', ['user' => $user, 'followers' => $followers])
        @endif
    </div>
</div>

<script src="{{ asset('/js/confirmDelete.js') }}" defer></script>
<script src="{{ asset('/js/confirmUnfollow.js') }}" defer></script>
@endsection
