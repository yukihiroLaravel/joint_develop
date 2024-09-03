<div class="container">
    <h5 class="mt-5 mb-4">フォロワー</h5>
    <ul class="list-unstyled">
        @foreach ($followers as $follower)
            <li class="media mb-4">
                <img class="mr-3 rounded-circle" src="{{ Gravatar::src($follower->email, 55) }}" alt="{{ $follower->name }}のアバター画像">
                <div class="media-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mt-0 mb-1"><a href="{{ route('user.show', $follower->id) }}">{{ $follower->name }}</a></h5>
                        @if (Auth::check() && Auth::id() !== $follower->id)  {{-- 自分自身でないかを確認 --}}
                            @if (Auth::user()->isFollowing($follower->id))
                                <form method="POST" action="{{ route('unfollow', $follower->id) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-secondary rounded-pill">フォロー中</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('follow', $follower->id) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-primary rounded-pill">フォローする</button>
                                </form>
                            @endif
                        @elseif (!Auth::check())  {{-- ログインしていない場合 --}}
                            <a href="{{-- route('login') --}}" class="btn btn-outline-primary rounded-pill">フォローする</a>
                        @endif
                    </div>
                    <p class="mb-0 text-muted">{{ $follower->email }}</p>
                </div>
            </li>
        @endforeach
        <div class="mt-3">
            {{ $followers->links('pagination::bootstrap-4') }}
        </div>
    </ul>
</div>
