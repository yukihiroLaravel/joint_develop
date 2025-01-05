@extends('layouts.app')
@section('content')
<div class="text-center h5">
    <div class="text-left d-inline-block w-75 mb-2">
        <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
        <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $post->user_id) }}">{{ $post->user->name }}</a></p>
    </div>
    <div class="text-left d-inline-block w-75">
        <p class="mb-2">{{ $post->content }}</p>
        <!-- 画像を選択していれば、画像が表示される -->
        @if ($post->image !== null)
            <img class="mb-2" src="{{ Storage::url($post->image) }}" alt="画像投稿">
        @endif
        <p class="text-muted">{{ $post->updated_at }}</p>
    </div>
</div>
<div class="w-75 m-auto">
        @include('commons.error_messages')
    </div>
    @if (Auth::check())
    <div class="text-center mb-3">
        <form method="POST" action="{{ route('post.replies', $post->id) }}" enctype="multipart/form-data" class="d-inline-block w-75">
        @csrf
            <div class="form-group">
                <textarea class="form-control" name="content" rows="4">{{ old('content') }}</textarea>
                <div class="text-left mt-3">
                    <button type="submit" class="btn btn-primary">返信する({{ $post->replies->count() }})</button>
                    <input class="ml-3" type="file" name="image">
                </div>
            </div>
        </form>
    </div>
    @endif
<ul class="list-unstyled">
    @foreach ($replies as $reply)       
            <li class="mb-3 text-center">
                <div class="text-left d-inline-block w-75 mb-2">
                    <img class="mr-2 rounded-circle" src="{{ Gravatar::src($reply->user->email, 55) }}" alt="ユーザのアバター画像">
                    <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $post->user_id) }}">{{ $reply->user->name }}</a></p>
                </div>
                
                <div class="">
                    <div class="text-left d-inline-block w-75">
                        <p class="mb-2">{{ $reply->content }}</p>
                        <!-- 画像を選択していれば、画像が表示される -->
                        @if ($reply->image !== null)
                            <img class="mb-2" src="{{ Storage::url($reply->image) }}" alt="画像投稿">
                        @endif
                        <p class="text-muted">{{ $reply->updated_at }}</p>
                    </div>
                    <!-- ログインしている場合 -->
                    @if (Auth::id() === $reply->user->id)
                        <div class="w-75 pb-3 m-auto">
                            <div class="d-flex justify-content-start">
                                <a href="{{ route('reply.edit', $reply->id) }}" class="btn btn-primary">編集する</a>
                                <form method="POST" action="{{ route('reply.delete', $reply->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger ml-2">削除</button>
                                </form>
                                    <!-- 画像を投稿していれば、ボタンが表示される -->
                                    @if ($reply->image !== null)
                                        <form method="POST" action="{{ route('picture.delete', $reply->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger ml-2">画像のみ削除</button>
                                        </form>
                                    @endif
                            </div>
                        
                        </div>
                        @endif
                </div>
            </li>
    @endforeach
</ul>
<div class="m-auto" style="width: fit-content">
{{ $replies->links('pagination::bootstrap-4') }}
</div>
@endsection