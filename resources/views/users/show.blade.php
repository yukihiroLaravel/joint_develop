@extends('layouts.app')
@section('content')
    <div class="row">
        <aside class="col-sm-4 mb-5">
            <div class="card card-bg-common">
                <div class="card-header d-flex">
                    <h3 class="card-title flex-fill user-name">{{ $user->name }}</h3>
                    <div class="flex-fill">
                        @include('follow.follow_btn')
                    </div>
                </div>

                <div class="card-body">
                    <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 400) }}" alt="ユーザのアバター画像">
                    @if (Auth::id() === $user->id)
                        <div class="mt-3">
                            <a href="" class="btn btn-block btn-bg-common">ユーザ情報の編集</a>
                            {{-- ユーザ退会ボタンあとで削除ここから↓ --}}
                            <a class="btn text-light" data-toggle="modal" data-target="#deleteConfirmModal" style="background-color: #dc3545; color: white;">退会する</a>
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
                                            <form action="{{ route('user.delete', $user->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">退会する</button>
                                            </form>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- ユーザ退会ボタンあとで削除ここまで↑ --}}
                        </div>
                    @endif
                </div>
            </div>
        </aside>
        <div class="col-sm-8">
            <ul class="nav nav-tabs nav-justified mb-3">
                <li class="nav-item"><a href="{{ route('user.show', $user->id) }}"
                        class="nav-link {{ Request::is('users/' . $user->id) ? 'active' : '' }}">タイムライン</a></li>
                <li class="nav-item"><a href="{{ route('followings' , $user->id) }}" class="nav-link {{ Request::is('users/' . $user->id . '/followings') ? 'active' : '' }}">フォロー中</a></li>
                <li class="nav-item"><a href="{{ route('followers' , $user->id) }}" class="nav-link {{ Request::is('users/' . $user->id . '/followers') ? 'active' : '' }}">フォロワー</a></li>
            </ul>
            @include('posts.posts')
        </div>
    </div>
@endsection