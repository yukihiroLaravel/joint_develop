@if (Auth::check() && Auth::id() !== $post->user_id)
    @if (Auth::user()->isFollow($post->user_id))
        <form method="POST" action="{{ route('unFollow', $post->user_id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">フォローを外す</button>
        </form>
    @else
        <form method="POST" action="{{ route('follow', $post->user_id) }}">
            @csrf
            <button type="submit" class="btn btn-success">フォローする</button>
        </form>
    @endif
@endif
