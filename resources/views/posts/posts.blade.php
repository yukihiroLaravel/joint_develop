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
                    </p>
                @endif
            </div>
            <div>
                <div class="text-left d-inline-block w-75">
                    @if (isset($post->img_path))
                    <p class="mb-2">
                        {!!nl2br(e($post->text))!!}
                    </p>
                    <img src="{{ Storage::url($post->img_path) }}" class="mb-2" alt="">
                    @else
                    <p class="mb-2">
                        {!!nl2br(e($post->text))!!}
                    </p>
                    @endif
                    <div class="flex-box  adjust-center">
                        <p class="text-muted mb-2 mr-2">{{ $post->updated_at }}</p>
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
                @include('comments.comments')
            </div>
        </li>
    </ul>
@endforeach
<div class="m-auto" style="width: fit-content">
    {{ $posts->links('pagination::bootstrap-4') }}
</div>
