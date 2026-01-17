@if (Auth::check() && Auth::id() !== $post->user_id)
    @if (Auth::user()->isLike($post->id))
        <form method="POST" action="{{ route('unlike', $post->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">いいね！を外す</button>
        </form>
    @else
        <form method="POST" action="{{ route('like', $post->id) }}">
            @csrf
            <button type="submit" class="btn btn-success">いいね！を押す</button>
        </form>
    @endif
@endif