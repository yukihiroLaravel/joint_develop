@extends('layouts.app')
@section('content')
<ul class="list-unstyled">
    <li class="mb-3 text-center">
        <div class="text-left d-inline-block w-75 mb-2">
            @if (isset($post->user->profile_image) && $post->user->profile_image)
                <img class="rounded-circle img-fluid" style="max-width: 70px; height: auto;" src="{{ asset('storage/profile_images/' . $post->user->profile_image) }}" alt="ユーザーのプロフィール画像">
            @else
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
            @endif         
            <p class="mt-3 mb-0 d-inline-block">
                <a href="{{ route('users.show', $post->user->id) }}">{{ $post->user->name }}</a>
            </p>
        </div>
        <div>
            @if ($post->youtube_id)
                <iframe width="290" height="163.125" src="{{ 'https://www.youtube.com/embed/'.$post->youtube_id }}?controls=1&loop=1&playlist={{ $post->youtube_id }}" frameborder="0"></iframe>
            @else
                <iframe width="290" height="163.125" src="https://www.youtube.com/embed/" frameborder="0"></iframe>
            @endif
        </div>
        <div class="text-left d-inline-block w-75">
            <p class="mb-2 text-break">{{ $post->content }}</p>
            <p class="text-muted">{{ $post->created_at }}</p>
            <div class="container">
                <label for="content">リプライ一覧</label>
                <ul class="list-unstyled">
                    @foreach ($replies as $reply)
                        <li class="mb-3">
                            <div class="d-flex">
                                <div class="mr-2">
                                @if (isset($reply->user->profile_image) && $reply->user->profile_image)
                                    <img class="rounded-circle" style="max-width: 55px; height: auto;" src="{{ asset('storage/profile_images/' . $reply->user->profile_image) }}" alt="ユーザーのプロフィール画像">
                                @else
                                    <img class="rounded-circle" src="{{ Gravatar::src($reply->user->email, 55) }}" alt="ユーザのアバター画像">
                                @endif                                
                                </div>
                                <div>
                                    <p class="mt-2 mb-2">
                                        <a href="{{ route('users.show', $reply->user->id) }}">{{ $reply->user->name }}</a>
                                        <span class="text-muted ml-2">{{ $reply->created_at }}</span>
                                    </p>
                                    <p class="mt-0 ml-2">{{ $reply->content }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="mt-2 mb-2">
                                    <a  href="{{ route('users.show',$reply->user_id) }}">{{ $reply->user->name }}</a>
                                    <span class="text-muted ml-2">{{ $reply->created_at }}</span>
                                </p>
                                <p class="mt-0 ml-2">{{ $reply->content }}</p>
                            </div>
                        </div>
                        @if(Auth::check() && Auth::id() == $reply->user_id)
                        <div class="d-flex justify-content-between w-50 pb-3 m-auto">
                            <!-- 投稿編集 -->
                            <a href="{{ route('replies.edit',['postId' => $post->id, 'replyId' => $reply->id]) }}" >
                                <i class="fa fa-edit fa-2x" style="color: black; "></i>
                            </a>
                            <!-- 投稿削除 -->
                            <form id="delete-form">
                                <i class="fa fa-trash fa-2x" style="color: red; cursor: pointer;" data-toggle="modal" data-target="#replyDeleteConfirmModal"></i>
                            </form>
                            <div class="modal fade" id="replyDeleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4>確認</h4>
                                        </div>
                                        <div class="modal-body">
                                            <label>本当に削除しますか？</label>
                                        </div>
                                        <div class="modal-footer d-flex justify-content-between">
                                            <form method="POST" action="{{ route('replies.destroy', ['postId' => $post->id, 'replyId' => $reply->id]) }}"> 
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">削除する</button>
                                            </form>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif    
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </li>
</ul>

<div class="m-auto" style="width: fit-content">{{ $replies->links('pagination::bootstrap-4') }}</div>

@endsection