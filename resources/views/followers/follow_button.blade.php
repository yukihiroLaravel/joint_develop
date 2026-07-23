{{-- design-update: フルサイズのブロックボタンから小さなピルボタンに変更。フォロー中は押すと解除されるため「フォロー解除」表示に変更（機能は変更なし） --}}
@if (Auth::check() && Auth::id() !== $user->id)
    @if (Auth::user()->isFollowing($user->id))
        <form method="POST" action="{{ route('users.unfollow', $user->id) }}" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="du-follow-pill is-following du-btn-muted">フォロー解除</button>
        </form>
    @else
        <form method="POST" action="{{ route('users.follow', $user->id) }}" class="d-inline">
            @csrf
            <button type="submit" class="du-follow-pill du-btn-link">フォローする</button>
        </form>
    @endif
@endif