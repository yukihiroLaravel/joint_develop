@extends('layouts.app')
@section('content')
    <div class="row">
        <aside class="col-sm-4 mb-5">
            <div class="card bg-info">
                <div class="card-header">
                    <h3 class="card-title text-light">{{ Auth::user()->name }}</h3>
                </div>
                <div class="card-body">
                    <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 400) }}" alt="">
                    <div class="mt-3">
                        <a href="ユーザー編集のルーター" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                    </div>

                    {{-- フォローボタン --}}
                    <div>
                        @php
                            $id = $user->id;
                        @endphp
                        @if (Auth::check() && Auth::id() !== $id)
                            @if (Auth::user()->isFollow($id))
                                <form method="POST" action="{{ route('unfollow', $id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-primary btn-block">フォロー解除</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('follow', $id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-block">フォローする</button>
                                </form>
                            @endif
                        @endif
                    </div>
                    {{-- フォローぼたん --}}

                </div>
            </div>
        </aside>
        <div class="col-sm-8">
            <ul class="nav nav-tabs nav-justified mb-3">
                <li class="nav-item"><a href=""
                        class="nav-link {{ Request::is('users/' . $user->id) ? 'active' : '' }}">タイムライン</a></li>
                <li class="nav-item"><a href="#" class="nav-link">
                        <p>フォロー中</p>
                        <div class="badge badge-secondary">{{ $countFollowUsers }}</div>
                    </a></li>
                <li class="nav-item"><a href="#" class="nav-link">
                        <p>フォロワー</p>
                        <div class="badge badge-secondary">{{ $countFollowerUsers }}</div>
                    </a></li>
            </ul>
        </div>
        <ul>

        </ul>
    </div>
@endsection
