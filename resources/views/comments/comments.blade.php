@extends('layouts.app')
@section('content')
    <h2 class="mt-5">投稿詳細</h2>
    @include('commons.error_messages')
    <div class="d-flex align-items-center flex-column">
        <div class="col-12 col-md-10 col-lg-8 mb-5 pt-3 pb-3" style="border: 1px solid silver; border-radius:5px;">
            <div class="d-flex align-items-center justify-content-centor mb-2">
                <img class="mr-2 rounded-circle" src="{{ $iconSrc }}" alt="ユーザのアバター画像">
                <p class="mb-0"><a href="{{ route('user.show', Auth::id()) }}">{{ Auth::user()->name }}</a>
                </p>
            </div>
            <div>
                <div class="text-left d-inline-block col-12 mb-2">
                    <p class="mb-2 post_content">{!! nl2br(e($post->content)) !!}</p>
                    <time class="text-muted">{{ $post->created_at }}</time>
                </div>
                <div class="d-flex m-auto">
                    <form method="POST" action="{{ route('post.delete', $post->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger mr-2">削除</button>
                    </form>
                    <a href="{{ route('post.edit', $post->id) }}" class="btn btn-primary">編集する</a>
                </div>
            </div>
        </div>
        @if (Auth::check())
        <div class="text-center mb-3 pt-3">
            <form method="POST" action="{{ route('comments.store') }}" class="d-inline-block w-75">
                @csrf
                <div class="form-group">
                    <textarea class="form-control" name="content" rows="4">{{ old('content') }}</textarea>
                    <div class="text-right mt-3">
                        <button type="submit" class="btn btn_accent-color">投稿する</button>
                    </div>
                </div>
            </form>
        </div>
        @endif
        <h5 class="text-center mb-3 pb-2 pr-4 pl-4" style="border-bottom: 4px solid #17a2b8">コメント一覧</h5>
        <ul class="col-12 list-unstyled d-flex align-items-center flex-column show_list_style">
            <li class="col-12 col-md-10 col-lg-8 pt-3 pb-3">
                <div class="d-flex align-items-center justify-content-centor mb-2">
                    <img class="mr-2 rounded-circle" src="{{ $iconSrc }}" alt="ユーザのアバター画像">
                    <p><a href="{{ route('user.show', Auth::id()) }}">{{ Auth::user()->name }}</a>
                    </p>
                </div>
                <div>
                    <div class="text-left d-inline-block col-12 mb-2">
                        <p class="mb-2 post_content">{!! nl2br(e($comment->content)) !!}</p>
                        <time class="text-muted">{{ $comment->created_at }}</time>
                    </div>
                    <div class="d-flex m-auto">
                        <form method="POST" action="{{ route('comments.delete', $comment->id) }}">
                            <button type="submit" class="btn btn-danger mr-2">削除</button>
                        </form>
                        <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-primary">編集する</a>
                    </div>
                </div>
            </li>
        </ul>
        <div class="d-flex justify-content-center">
            {{ $usersList->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection