@if (Auth::check() && Auth::id() !== $user->id)
    @if (Auth::user()->isFollowing($user->id))
        <form method="POST" action="{{ route('users.unfollow', $user->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="btn btn-warning btn-sm shadow-sm"
                style="border: 2px solid #4a3f35; font-weight: bold;">
                <i class="fas fa-user-slash"></i> フォロー解除
            </button>
        </form>
    @else
        <form method="POST" action="{{ route('users.follow', $user->id) }}">
            @csrf
            <button type="submit"
                class="btn btn-success btn-sm shadow-sm"
                style="border: 2px solid #2e5c2b; font-weight: bold;">
                <i class="fas fa-user-plus"></i> フォローする
            </button>
        </form>
    @endif
@endif
