@extends('layouts.app')

@section('content')
    <div class="row">
        <aside class="col-sm-4 mb-5">
            <div class="card" style="background-color: #d8f3dc;">
                <div class="card-header">
                    <h3 class="card-title" style="color:#557a6b;">
                        {{ $user->name }}
                    </h3>
                </div>

                <div class="card-body">

                    @if ($user->avatar)
                        <img
                            class="rounded-circle img-fluid d-block mx-auto"
                            src="{{ asset('storage/' . $user->avatar) }}"
                            alt="{{ $user->name }}のアバター画像"
                        >
                    @else
                        <img
                            class="rounded-circle img-fluid d-block mx-auto"
                            src="{{ Gravatar::src($user->email, 300) }}"
                            alt="{{ $user->name }}のアバター画像"
                        >
                    @endif


                    @if (Auth::check() && Auth::id() === $user->id)
                        <div class="mt-3">
                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary btn-block">
                                ユーザ情報の編集
                            </a>
                        </div>

                        <div class="mt-3">
                            <a
                                class="btn btn-danger text-light btn-block"
                                data-toggle="modal"
                                data-target="#deleteConfirmModal"
                            >
                                退会する
                            </a>
                        </div>

                        <div
                            class="modal fade"
                            id="deleteConfirmModal"
                            tabindex="-1"
                            role="dialog"
                            aria-labelledby="basicModal"
                            aria-hidden="true"
                        >
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4>確認</h4>
                                    </div>

                                    <div class="modal-body">
                                        <label>本当に退会しますか？</label>
                                    </div>

                                    <div class="modal-footer d-flex justify-content-between">
                                        <form method="POST" action="{{ route('user.destroy', $user->id) }}">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger">
                                                退会する
                                            </button>
                                        </form>

                                        <button type="button" class="btn btn-default" data-dismiss="modal">
                                            閉じる
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif (Auth::check())
                        <div class="mt-3">
                            @if (Auth::user()->isFollowing($user->id))
                                <form method="POST" action="{{ route('user.unfollow', $user->id) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger btn-block">
                                        フォロー解除
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('user.follow', $user->id) }}">
                                    @csrf

                                    <button type="submit" class="btn btn-primary btn-block">
                                        フォロー
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </aside>

        <div class="col-sm-8">
            <ul class="nav nav-tabs nav-justified mb-3">
                <li class="nav-item">
                    <a
                        href="{{ route('user.show', $user->id) }}"
                        class="nav-link {{ Request::is('users/' . $user->id) ? 'active' : '' }}"
                    >
                        タイムライン
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        href="{{ route('user.followings', $user->id) }}"
                        class="nav-link {{ Request::is('users/' . $user->id . '/followings') ? 'active' : '' }}"
                    >
                        フォロー中
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        href="{{ route('user.followers', $user->id) }}"
                        class="nav-link {{ Request::is('users/' . $user->id . '/followers') ? 'active' : '' }}"
                    >
                        フォロワー
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        href="{{ route('user.reactions', $user->id) }}"
                        class="nav-link {{ Request::is('users/' . $user->id . '/reactions') ? 'active' : '' }}"
                    >
                        リアクション
                    </a>
                </li>

            </ul>

            @if ($type === 'timeline')
                @include('posts.posts', [
                    'posts' => $posts,
                    'reactionTypes' => $reactionTypes,
                ])
            @elseif ($type === 'followings')
                @include('users.users', [
                    'users' => $users,
                    'emptyMessage' => 'フォロー中のユーザはいません。'
                ])
            @elseif ($type === 'followers')
                @include('users.users', [
                    'users' => $users,
                    'emptyMessage' => 'フォロワーはいません。'
                ])
            
            @elseif ($type === 'reactions')
                <h4 class="mb-3">リアクション集計</h4>

                @foreach ($reactionTypes as $typeKey => $label)
                    <div class="d-flex align-items-center justify-content-between border-bottom py-3">

                        <div class="d-flex align-items-center">
                            <img
                                src="{{ asset('images/reactions/' . $typeKey . '.png') }}"
                                alt="{{ $label }}"
                                style="width: 50px; height: 50px; object-fit: contain;"
                                class="mr-3"
                            >

                            <span class="font-weight-bold">
                                {{ $label }}
                            </span>
                        </div>

                        <span class="font-weight-bold">
                            {{ $reactionCounts[$typeKey] ?? 0 }}件
                        </span>

                    </div>
                @endforeach    
            @endif

        </div>
    </div>
@endsection