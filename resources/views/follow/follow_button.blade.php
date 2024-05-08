@if (Auth::check() && Auth::id() !== $post->user->id)
    @if (Auth::user()->isFollowing($post->user->id))
        <form method="POST" action="{{ route('unfollow', $post->user->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">フォローを外す</button>
        </form>
    @else
        <form method="POST" action="{{ route('follow', $post->user->id)}}">
            @csrf
            <button type="submit" class="btn btn-success">フォローする</button>
        </form>
    @endif
@endif