@if (Auth::check() && Auth::id() !== $post->user->id)
    @if (Auth::user()->isFollow($post->user->id))
        <form method="POST" action="{{ route('unfollow', $post->user->id) }}">
            @csrf
            @method('DELETE')
            <div class="text-left d-inline-block w-75 mb-2">
            <button type="submit" class="btn btn-danger ">フォローを外す</button>
            </div>
        </form>
    @else
        <form method="POST" action="{{ route('follow', $post->user->id) }}">
            @csrf
            <div class="text-left d-inline-block w-75 mb-2">
            <button type="submit" class="btn btn-success ">フォローする</button>
            </div>
        </form>
    @endif
@endif