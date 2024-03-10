@if (Auth::check() && Auth::id() !== $post->user_id && $post->favorite_flag)
    @if (Auth::user()->isFavorite($post->id))
        <form method="POST" action="{{ route('unfavorite', $post->user_id && $post->favorite_flag) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">いいね！を外す</button>
        </form>
    @else
        <form method="POST" action="{{ route('favorite', $post->id) }}">
            @csrf
            <button type="submit" class="btn btn-success">いいね！を押す</button>
        </form>
    @endif
@endif
