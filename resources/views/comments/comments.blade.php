@extends('layouts.app')
@section('content')
@include('commons.flash_message')
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
                    @if (isset($post->img_path))
                        <p>{!!nl2br(e($post->text))!!}</p>
                        <img src="{{ Storage::url($post->img_path) }}" class="mb-2" alt="">
                    @else
                        <p>{!!nl2br(e($post->text))!!}</p>
                    @endif
                    <div class="flex-box  adjust-center">
                        <i class="far fa-comment-dots"></i>
                        <p class="badge badge-pill badge-light mb-2 mr-2">
                            @php
                                $countComments = $post->comments()->count();
                            @endphp
                            <span>{{ $countComments }}件</span>
                        </p>
                        <i class="far fa-thumbs-up mb-2"></i>
                        <p class="badge badge-pill badge-light mb-2 mr-2">
                            @php
                                $countFavoritePostUsers = $post->favoritePostUsers()->count();
                            @endphp
                            <span>{{ $countFavoritePostUsers }}</span>
                        </p>
                        <p>
                            @if (Auth::check() && Auth::id() !== $post->user_id)
                                @if (Auth::user()->isFavoritePosts($post->id))
                                    <form method="POST" action="{{ route('unfavorite.post', $post->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm mb-2">いいね！を外す</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('favorite.post', $post->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success btn-sm mb-2">いいね！を押す</button>
                                    </form>
                                @endif
                            @endif
                        </p>
                    </div>
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
                <div class="card text-left d-inline-block w-75 mb-2">
                    <h5 class="card-header">
                        コメント
                        @php
                        $countComments = $post->comments()->count();
                        @endphp
                        <div div class="badge badge-secondary">{{ $countComments }}件</div>
                    </h5>
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
                        @include('comments.comment_list')
                    </div>
                </div>
            </div>
        </li>
    </ul>
<div class="m-auto" style="width: fit-content">
    {{ $comments->links('pagination::bootstrap-4') }}
</div>
@endsection