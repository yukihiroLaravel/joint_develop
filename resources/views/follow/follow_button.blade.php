@if (Auth::check() && Auth::id() !== $user->id)
    <div class="d-inline-block">
        @if (Auth::user()->isFollow($user->id))
            <form method="POST" action="{{route('unfollow', $user->id)}}">
                @csrf
                <button type="submit" class="btn btn-danger">フォローを外す</button>
            </form>
        @else
            <form method="POST" action="{{route('follow', $user->id)}}">
                @csrf
                <button type="submit" class="btn btn-info btn-sm">フォローする</button>
            </form>
        @endif
    </div>
@endif