@extends('layouts.app')
@section('content')
    <div class="row">
        <aside class="col-sm-4 mb-5">
            <div class="card bg-info">
                <div class="card-header">
                    <h3 class="card-title text-light">{{ $user->name }}</h3>
                </div>
                <div class="card-body">
                    <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 400) }}" alt="ユーザのアバター画像">
                    @if (Auth::id() === $user->id)
                        <div class="mt-3">
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                        </div>
                    @endif
                </div>
            </div>
        </aside>
        <div class="col-sm-8">
            <ul class="nav nav-tabs nav-justified mb-3">
                <li class="nav-item"><a href="{{ route('user.show', $user->id) }}" class="nav-link {{ Request::routeIs('user.show') ? 'active' : '' }}">タイムライン</a></li>
                <li class="nav-item"><a href="#" class="nav-link">フォロー中</a></li>
                <li class="nav-item"><a href="#" class="nav-link">フォロワー</a></li>
            </ul>
            <!-- トップページの投稿表示完成後、以下を"＠include('posts.posts')"に変更する -->
            <ul class="list-unstyled">
                @foreach ($posts as $post)
                  <li class="mb-3 text-center">
                        <div class="text-left d-inline-block w-75 mb-2">
                            <img class="mr-2 rounded-circle" src="{{ Gravatar::src($user->email, 55) }}" alt="ユーザのアバター画像">
                            <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $user->id) }}">{{ $user->name }}</a></p>
                        </div>
                        <div class="">
                            <div class="text-left d-inline-block w-75">
                                <p class="mb-2">{{ $post->content }}</p>
                                <p class="text-muted">{{ $post->created_at }}</p>
                            </div>
                        </div>
                        @if (Auth::id() === $post->user_id)
                            <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                                <form method="" action="">
                                <button type="submit" class="btn btn-danger">削除</button>
                                </form>
                                <a href="" class="btn btn-primary">編集する</a>
                            </div>
                        @endif
                   </li>
                @endforeach
            </ul>
            <div class="m-auto" style="width: fit-content">{{ $posts->links('pagination::bootstrap-4') }}</div>   
            <!-- トップページの投稿表示完成後、ここまでを"＠include('posts.posts')"に変更する -->
            </div>
    </div>
@endsection