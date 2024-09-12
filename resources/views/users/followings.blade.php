<h5 class="mt-5 mb-4">フォローしているユーザー</h5>
@foreach ($followings as $following)
    <div class="list-group-item">
        <li class="media mb-1">
            <img class="mr-3 rounded-circle" 
                  src="{{ Gravatar::src($following->email, 55) }}" alt="{{ $following->name }}のアバター画像">
            <div class="media-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mt-0 mb-1"><a href="{{ route('user.show', $following->id) }}">{{ $following->name }}</a></h5>
                    @if (Auth::check() && Auth::id() !== $following->id)  {{-- 自分自身でないかを確認 --}}
                        @if (Auth::user()->isFollowing($following->id))
                            <form method="POST" action="{{ route('unfollow', $following->id) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-secondary rounded-pill">フォロー中</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('follow', $following->id) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary rounded-pill">フォローする</button>
                            </form>
                        @endif
                    @elseif (!Auth::check())  {{-- ログインしていない場合 --}}
                        <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill">フォローする</a>
                    @endif
                </div>
                <p class="mb-0 text-muted">{{ $following->email }}</p>
            </div>
        </li>
    </div>
@endforeach
<div class="mt-3">
    {{ $followings->links('pagination::bootstrap-4') }}
</div>
