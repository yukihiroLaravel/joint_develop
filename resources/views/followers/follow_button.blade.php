{{-- design-update: 小さなピルボタン。普段は「フォロー中」、ホバー時のみ「フォローをはずす」表示に切り替え --}}
@if (Auth::check() && Auth::id() !== $user->id)
    @if (Auth::user()->isFollowing($user->id))
        <form method="POST" action="{{ route('users.unfollow', $user->id) }}" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="du-follow-pill is-following du-btn-muted">
                <span class="du-follow-label-default">フォロー中</span>
                <span class="du-follow-label-hover">フォローをはずす</span>
            </button>
        </form>
    @else
        <form method="POST" action="{{ route('users.follow', $user->id) }}" class="d-inline">
            @csrf
            <button type="submit" class="du-follow-pill du-btn-link">フォローする</button>
        </form>
    @endif
@endif
