@if(Auth::check() && Auth::id() !== $user->id)
    @if(Auth::user()->isFollowing($user->id))
        <form method="POST" action="{{ route('unfollow',$user->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">フォロー外す</button>
        </form>
    @else
        <form method="POST" action="{{ route('follow',$user->id) }}">
            @csrf
            <button type="submit" class="btn btn-success">フォローする</button>
        </form>
    @endif
@endif