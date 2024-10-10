@extends('layouts.app')
@section('content')
<div class="center jumbotron bg-info">
    <div class="text-center text-white mt-2 pt-1">
        <h1><i class="fab fa-telegram fa-lg pr-3"></i>Topic Posts</h1>
    </div>
</div>
<h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>
    <div class="w-75 m-auto">@include('commons.error_messages')</div>
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
    @if (Auth::check())
    <div class="text-center mb-3">
        <form method="POST" action="{{ route('post.store') }}" class="d-inline-block w-75">
            @csrf
            <div class="form-group">
                <textarea class="form-control" name="content" rows="4"></textarea>
                <div class="text-left mt-3">
                    <button type="submit" class="btn btn-primary">投稿する</button>
                </div>
            </div>
        </form>
    </div>
    @endif    
@include('posts.posts', ['posts => $posts'])
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
    @if (isset($submitted) && $submitted)  {{-- 「検索ボタン」を押されている場合で、 --}}
        @if ($keyword == "" || $keyword == NULL)
            <p class="text-center">キーワードを入力してください。</p>
        @else
            @if (count($posts) > 0)
                <p class="text-center">「{{ $keyword }}」で検索しました。</p>
            @else
                <p class="text-center">「{{ $keyword }}」を含む投稿が見つかりません…</p>
            @endif
        @endif
    @endif
@include('posts.posts', ['posts' => $posts, 'keyword' => $keyword])
@endsection
