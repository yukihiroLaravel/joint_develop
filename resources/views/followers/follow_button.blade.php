{{-- design-update: フルサイズのブロックボタンから小さなピルボタンに変更。フォロー中は「フォロー中」表示（クリックで解除、機能は変更なし） --}}
@if (Auth::check() && Auth::id() !== $user->id)
    @if (Auth::user()->isFollowing($user->id))
        <form method="POST" action="{{ route('users.unfollow', $user->id) }}" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="du-follow-pill is-following">フォロー中</button>
        </form>
    @else
        <form method="POST" action="{{ route('users.follow', $user->id) }}" class="d-inline">
            @csrf
            <button type="submit" class="du-follow-pill">フォローする</button>
        </form>
    @endif
@endif