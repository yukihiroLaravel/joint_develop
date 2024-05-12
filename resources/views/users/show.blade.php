@extends('layouts.app')
@section('content')
    <div class="row">
        <aside class="col-sm-4 mb-5">
            <div class="card bg-info">
                <div class="card-header">
                    <h3 class="card-title text-light">{{ $user->name }}</h3>
                </div>
                <div class="card-body">
                    <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 308) }}" alt="ユーザのアバター画像">
                    <div class="mt-3">
                        <a href="" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                    </div>
                </div>
            </div>
            <!-- ここにフォローボタンを挿入 -->
            <div style="margin-top: 20px;"> <!-- 20ピクセルの上マージンを追加 -->
                @include('follow.follow_button', ['user' => $user])
            </div>
        </aside>
        <div class="col-sm-8">
            <ul class="nav nav-tabs nav-justified mb-3">
                <li class="nav-item"><a href="" class="nav-link {{ Request::routeIs('users.show') ? 'active' : '' }}">タイムライン</a></li>
                <li class="nav-item"><a href="#" class="nav-link">フォロー中</a></li>
                <li class="nav-item"><a href="#" class="nav-link">フォロワー</a></li>
            </ul>
        <!-- タイムライン表示 -->
            <div class="tab-content">
                <div class="tab-pane active" id="timeline">
                    @foreach ($posts as $post)
                    <div class="media mb-3">
                        <img class="mr-3 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
                        <div class="media-body">
                            <h5 class="mt-0 mb-1">{{ $post->user->name }}</h5>
                            <p>{{ $post->content }}</p>
                            <small>{{ $post->created_at->diffForHumans() }}</small>
                            @if (Auth::id() == $post->user->id)
                            <a href="#" class="btn btn-primary">編集する</a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            {{ $posts->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
