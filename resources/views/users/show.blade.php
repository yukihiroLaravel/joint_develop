@extends('layouts.app')
@section('content')
    <div class="row">
        <aside class="col-sm-4 mb-5">
            <div class="card bg-info">
                <div class="card-header">
                    <h3 class="card-title text-light">{{ $user->name }}</h3>
                </div>
                <div class="card-body">
                    @if (isset($user) && $user->profile_image)
                        <img class="rounded-circle img-fluid" src="{{ asset('storage/images/' . $user->profile_image) }}" alt="ユーザーのプロフィール画像">
                    @else
                        <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 300) }}" alt="ユーザのアバター画像">
                    @endif
                
                    @if (Auth::id() == $user->id)
                    <form action="{{ route('users.upload.image', ['id' => $user->id]) }}" method="post" enctype="multipart/form-data" class="mt-2">
                        @csrf
                        <input type="file" name="image">
                        <input type="submit" value="写真をアップロード">
                    </form>
                        <div class="mt-3">
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                        </div>
                    @endif
                    @if (Auth::check() && Auth::id() !== $user->id)
                            @include('follow.follow_button', ['user' => $user])
                    @endif
                </div>
            </div>
        </aside>
        <div class="col-sm-8">
            <ul class="nav nav-tabs nav-justified mb-3">
                <li class="nav-item"><a href="{{ route('users.show', ['id' => $user->id]) }}" class="nav-link {{ Request::is('users/'. $user->id) ? 'active' : '' }}">タイムライン</a></li>
                <li class="nav-item"><a href="{{ route('followings', $user->id) }}" class="nav-link{{ Request::is('users/' . $user->id . '/followings') ? 'active' : '' }}">フォロー中</a></li>
                <li class="nav-item"><a href="{{ route('followers', $user->id) }}" class="nav-link{{ Request::is('users/' . $user->id . '/followers') ? 'active' : '' }}">フォロワー</a></li>
            </ul>
            @include('posts.posts', ['posts' => $posts]) 
        </div>
    </div>   
@endsection