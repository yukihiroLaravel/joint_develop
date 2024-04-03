<div class="d-inline-block">

    <div class="d-inline-block" style="color: dimgray;"><i
            class="fas fa-user-friends mr-2"></i>{{ $user->followerUsers()->count() }}
    </div>

    @if (Auth::check() && Auth::id() !== $id)
        @if (Auth::user()->isFollow($id))
            <form method="POST" action="{{ route('unfollow', $id) }}" class="ml-3 d-inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="follow_btn">フォローを外す</button>
            </form>
        @else
            <form method="POST" action="{{ route('follow', $id) }}" class="ml-3 d-inline-block">
                @csrf
                <button type="submit" class="follow_btn orange">フォローする</button>
            </form>
        @endif
    @endif

</div>
