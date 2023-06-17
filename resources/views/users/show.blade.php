@extends('layouts.app')
@section('content')
    <div class="row">
        <aside class="col-sm-4 mb-5">
            <div class="card bg-info">
                <div class="card-header d-inline-block">
                    <h3 class="card-title text-light">{{ $user->name }}
                         @include('follow.follow_button',['user'=> $user])
                    </h3>
                   </div>
                <div class="card-body">
                    <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 400) }}" alt="ユーザーアバター画像">
                    @if(Auth::id() === $user->id)
                        <div class="mt-3">
                            <a href="{{route('user.edit', $user->id)}}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                        </div>
                    @endif
                 </div>
            </div>
        </aside>
        <div class="col-sm-8">
            <ul class="nav nav-tabs nav-justified mb-3">
                <li class="nav-item"><a href="{{ route('user.show', $user->id) }}" class="nav-link {{ Request::routeIs('user.show') ? 'active' : '' }}">タイムライン</a></li>
                <li class="nav-item"><a href="{{ route('user.following', $user->id) }}" class="nav-link {{ Request::routeIs('user.following') ? 'active' : '' }}">フォロー中</a></li>
                <li class="nav-item"><a href="{{ route('user.follower', $user->id) }}" class="nav-link {{ Request::routeIs('user.follower') ? 'active' : '' }}">フォロワー</a></li>
            </ul>
            @if(isset($targets))
                <ul class="list-unstyled">
                    @foreach ($targets as $target)
                        <li class="mb-3 text-center">
                            <div class="text-left d-inline-block w-75 mb-2">
                                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($target->email, 55) }}" alt="ユーザのアバター画像">
                                <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $target->id) }}">{{ $target->name }}</a></p>
                                @include('follow.follow_button',['user'=> $target])
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="m-auto" style="width: fit-content">
                    {{ $targets->links("pagination::bootstrap-4") }}
                </div>
            @else
                @include( $list, ['posts' => $posts])
            @endif
        </div>
    </div>
@endsection
