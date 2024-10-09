@extends('layouts.app')
@section('content')
    <div class="row">
        <aside class="col-sm-4 mb-5">
            <div class="card bg-info">
                <div class="card-header">
                    <h3 class="card-title text-light">{{ $user->name }}</h3>
                    @include('follow.follow_button', ['user' => $user])
                </div>
                <div class="card-body">
                    <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 350) }}" alt="ユーザのアバター画像">
                        @if (Auth::check())
                        <div class="mt-3">
                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                        </div>
                        @endif
                </div>
            </div>
        </aside>
        <div class="col-sm-8">
            <ul class="nav nav-tabs nav-justified mb-3">
                <li class="nav-item"><a href="{{ route('user.show', $user->id) }}" class="nav-link {{ Request::routeIs('user.show') ? 'active' : '' }}">タイムライン<br><div class="badge badge-secondary">{{ $countPosts ?? '' }}</div></a></li>
                <li class="nav-item"><a href="{{ route('timelineFollowing', $user->id) }}" class="nav-link {{ Request::routeIs('timelineFollowing') ? 'active' : '' }}">フォロー中<br><div class="badge badge-secondary">{{ $countFollowing ?? '' }}</div></a></li>
                <li class="nav-item"><a href="{{ route('timelineFollowers', $user->id) }}" class="nav-link {{ Request::routeIs('timelineFollowers') ? 'active' : '' }}">フォロワー<br><div class="badge badge-secondary">{{ $countFollowers ?? '' }}</div></a></li>
            </ul>
            @include('posts.posts', ['posts' => $posts])
        </div>
    </div>

    <!-- フラッシュメッセージ用モーダル -->
    @if (session('flashmessage'))
        <div class="modal fade" id="flashMessageModal" tabindex="-1" role="dialog" aria-labelledby="flashMessageModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="flashMessageModalLabel">お知らせ</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{ session('flashmessage') }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- フラッシュメッセージ用モーダルを表示し、5秒後に自動的に閉じるスクリプト -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            // フラッシュメッセージがあればモーダルを表示
            @if (session('flashmessage'))
                $('#flashMessageModal').modal('show');
                // 5秒後にモーダルを自動的に閉じる
                setTimeout(function() {
                    $('#flashMessageModal').modal('hide');
                }, 5000);  // 5000ミリ秒 = 5秒
            @endif
        });
    </script>
@endsection
