@if (Auth::check())
    @if (Auth::id() != $post->user_id && ($post->favorite_flag || !is_null($post->parent_id)))
        @if (Auth::user()->isFavorite($post->id))
            <form method="POST" action="{{ route('favorites.unfavorite', $post->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-success btn-sm">いいね中</button>
            </form>
        @else
            <form method="POST" action="{{ route('favorites.favorite', $post->id) }}">
                @csrf
                <button type="submit" class="btn btn-outline-success btn-sm">いいね！</button>
            </form>
        @endif
    @endif
@endif

<div class="ml-2">
    <span class="text-muted">
        <i class="far fa-heart"></i>
        {{ $post->favoriteUsers()->count() }}
    </span>
</div>
