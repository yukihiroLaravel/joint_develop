@foreach ($posts as $post)
    <ul class="list-unstyled">
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                @if($post->user->email)
                    @if ($post->user->profile_image === null)
                        <img class="rounded-circle img-fluid" src="{{ Gravatar::src($post->user->email, 55) }}"
                            alt="{{ $post->user->name }}プロフィール画像">
                    @else
                        <img class="rounded-circle" src="{{ asset('storage/images/profiles/'.$post->user->profile_image) }}"
                            alt="{{ $post->user->name }}プロフィール画像" width="55" height="55">
                    @endif
                    <p class="mt-3 mb-0 d-inline-block">
                        <strong>
                            <a href="{{ route('user.show', $post->user->id) }}">
                                <i class="fas fa-user-alt"></i> {{$post->user->name}}
                            </a>
                        </strong>
                        {{ $post->updated_at->format('Y年m月d日H時i分') }}
                    </p>
                    <p class="text-muted"></p>
                @endif
            </div>
            <div class="">
                <div class="text-left d-inline-block w-75 mb-2">
                        <p>{!!nl2br(e($post->text))!!}</p>
                </div>
                @if ($post->user->id === Auth::id() )
                    <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                        <form method="POST" action="{{ route('post.delete', $post->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i> 削除
                            </button>
                        </form>
                        <a href="" class="btn btn-success"><i class="fas fa-edit"></i> 編集する</a>
                    </div>
                @endif
{{-- ここから コメント --}}
                <div class="card text-left d-inline-block w-75 mb-2">
                    <h5 class="card-header">コメント</h5>
                    <div class="card-body">
                        @if (Auth::check())
                            <div class="actions">
                                @error('comment.'. $post->id)
                                    <div class="alert alert-danger w-100 mb-2" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <form class="d-inline-block w-100 mb-2" method="POST" action="{{ route('comment.store') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input type="hidden" name="comments" />
                                        <input value="{{ $post->id }}" type="hidden" name="post_id" />
                                        <input value="{{ Auth::id() }}" type="hidden" name="user_id" />
                                        <textarea
                                            class="form-control @error('comment.'. $post->id) is-invalid @enderror comment-input"
                                            placeholder="コメントを投稿する ..." autocomplete="off" type="text"
                                            name="comment[{{ $post->id }}]" rows="2"
                                            cols="40">{{ old('comment.'. $post->id) }}</textarea><br>
                                        <div class="text-left">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-reply"></i> コメントする
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
{{-- ここから コメントリスト --}}
                        @foreach ($post->comments as $comment)
                            @php
                                $comment = $post->comments->last();
                            @endphp
                            @if ($loop->last)
                                <div class="text-left d-inline-block w-75 mb-2">
                                    <span>
                                        @if($comment->user->email)
                                            @if ($comment->user->profile_image === null)
                                                <img class="rounded-circle img-fluid" src="{{ Gravatar::src($comment->user->email, 55) }}"
                                                    alt="{{ $comment->user->name }}プロフィール画像">
                                            @else
                                                <img class="rounded-circle" src="{{ asset('storage/images/profiles/'.$comment->user->profile_image) }}"
                                                    alt="{{ $comment->user->name }}プロフィール画像" width="55" height="55">
                                            @endif
                                            <p class="mt-1 mb-1 d-inline-block">
                                                <a href="{{ route('user.show', $comment->user->id) }}">
                                                    <i class="fas fa-user-alt"></i> {{$comment->user->name}}
                                                </a>
                                            </p>
                                            {{ $comment->updated_at->format('Y年m月d日H時i分') }}
                                        @endif
                                    </span><br>
                                    <span class="card-text">
                                        {!!nl2br(e($comment->comment))!!}
                                    </span>
                                    @if ($comment->user->id == Auth::id())
                                        <form method="POST" action="{{ route('comment.delete', $comment->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger my-2">
                                                <i class="fas fa-trash-alt"></i> コメント削除
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endif
                        @endforeach
{{-- ここから コメントあれば表示、無ければ非表示 --}}
                        @if ($post->comments->count() > 0)
                            <div class="text-left d-inline-block w-75 mb-2">
                                <a href="{{ route('comment.show', $post->id) }}">
                                    ...さらにコメントを見る <i class="far fa-comment-dots"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
{{-- ここまで コメント --}}
            </div>
        </li>
    </ul>
@endforeach
<div class="m-auto" style="width: fit-content">
    {{ $posts->links('pagination::bootstrap-4') }}
</div>
@if ($post->comments->count() > 0)
    <div class="text-left d-inline-block w-75 mb-2">
        <a href="{{ route('comment.show', $post->id) }}">
            ...さらにコメントを見る <i class="far fa-comment-dots"></i>
        </a>
    </div>
@endif