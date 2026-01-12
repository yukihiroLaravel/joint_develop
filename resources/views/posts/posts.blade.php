<ul class="list-unstyled">
    @foreach ($posts as $post)
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $post->user) }}">{{$post->user->name}}</a></p>
            </div>
            <div class="">
                <div class="text-left d-inline-block w-75">
                    <p class="mb-2">{{$post->content}}</p>
                    @if($post->tags->count() > 0)
                        <div class="mb-2">
                            @foreach($post->tags as $tag_item)
                                <a href="{{ route('welcome', ['tag' => $tag_item->name]) }}" class="badge badge-info">
                                    <i class="fas fa-tag small"></i> {{ $tag_item->name }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                    <p class="text-muted">{{$post->created_at}}</p>
                </div>
                @if(Auth::check() && Auth::id() == $post->user_id)
                    <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                        <form method="POST" action="{{ route('posts.destroy', $post->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('本当に削除しますか？')">
                                削除
                            </button>
                        </form>
                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">編集する</a>
                    </div>
                @endif
                <div class="d-flex justify-content-center pb-3">
                    @include('favorites.favorite_button', ['post' => $post])
                </div>
            </div>
        </li>
    @endforeach
</ul>
<div class="m-auto" style="width: fit-content">{{$posts->links()}}</div>
