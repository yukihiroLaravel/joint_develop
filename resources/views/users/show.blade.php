@extends('layouts.app')
@section('content')
    @php
        $active = isset($posts) ? 'posts'
                : (isset($followings) ? 'followings'
                : (isset($followers) ? 'followers'
                : null));
    @endphp
    <div class="row">
        <aside class="col-sm-4 mb-5">
            <div class="card bg-info">
                <div class="card-header">
                    <h3 class="card-title text-light">{{ $user->name }}</h3>
                </div>
                <div class="card-body">
                    <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 300 ) }}" alt="ユーザーのアバター画像">
                    @if (Auth::check() && Auth::id() !== $user->id)
                        <div class="mt-3">
                            @if (Auth::user()->followings->contains($user->id))
                                <form action="{{ route('user.unfollow', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-block">フォロー解除</button>
                                </form>
                            @else
                                <form action="{{ route('user.follow', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-block">フォロー</button>
                                </form>
                            @endif
                        </div>
                    @endif
                    @if (Auth::id() === $user->id)                        
                        <div class="mt-3">
                            <a href="" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                            <!-- 退会ボタン-->
                            <a class="btn btn-danger btn-block text-light" data-toggle="modal" data-target="#deleteConfirmModal">退会する</a>
                        </div>
                    @endif
                </div>
            </div>
        </aside>
        <div class="col-sm-8">
            <ul class="nav nav-tabs nav-justified mb-3">
                <li class="nav-item"><a href="{{ route('user.show', $user->id) }}" class="nav-link {{ isset($posts) ? 'active' : '' }}">タイムライン</a></li>
                <li class="nav-item"><a href="{{ route('user.followings', $user->id) }}"class="nav-link {{ isset($followings) ? 'active' : '' }}">フォロー中</a></li>
                <li class="nav-item"><a href="{{ route('user.followers', $user->id) }}" class="nav-link {{ isset($followers) ? 'active' : '' }}">フォロワー</a></li>
            </ul>
            <!-- タブ内容 -->
                @include('users.tabs.' . $active)
        </div>
    </div>
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>確認</h4>
                </div>
                <div class="modal-body">
                    <label>本当に退会しますか？</label>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <form method="POST" action="{{ route('user.delete', $user->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">退会する</button>
                    </form>
                    <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                </div>
            </div>
        </div>
    </div>
@endsection