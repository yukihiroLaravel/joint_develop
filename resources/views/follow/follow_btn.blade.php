@if (Auth::check() && Auth::id() !== $user->id) 
    @if (Auth::user()->followings->contains($user->id))
        <form method="POST" action="{{ route('unfollow', $user->id) }}">
            @csrf
            <button type="submit" class="btn btn-danger">フォロー解除</button>
        </form>
    @else
        <form method="POST" action="{{ route('follow', $user->id) }}">
            @csrf
            <button type="submit" class="btn btn-primary">フォロー</button>
        </form>
    @endif
@endif
