@extends('layouts.app')
@section('content')
    <h2 class="mt-5">投稿詳細</h2>
    <p class="mb-2 post-content">{{ $post->content }}</p> <!-- 投稿内容を表示 -->
    <div class="d-flex justify-content-between">
        <div class="d-flex align-items-center">
            <p class="text-muted mb-0">{{ $post->created_at->format('Y年n月j日 G時i分') }}</p> <!-- 投稿日時を相対時間表記で表示  -->
            @include('favorite.favorite_button', ['post' => $post])
        </div>
        <div class="d-flex align-items-center">
            @if (Auth::id() == $post->user->id)
                <a href="{{ route('posts.edit', ['id' => $post->id]) }}" class="btn btn-primary btn-sm mr-2">編集</a>
                <a class="btn btn-danger btn-sm text-light" data-toggle="modal" data-target="#deleteConfirmModal">削除</a>
                <div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4>削除確認</h4>
                            </div>
                            <div class="modal-body">
                                <label>本当に削除してもよろしいでしょうか？</label>
                            </div>
                            <div class="modal-footer d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                                <form method="POST" action="{{ route('posts.destroy', $post->id) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">削除</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
