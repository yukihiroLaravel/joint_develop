<ul class="list-unstyled">
    @foreach ($posts as $post)
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $post->user->id) }}">{{ $post->user->name }}</a>　</p>
                <!-- フォローボタン -->
                <div class="d-inline-block">
                    @if (Auth::check() && Auth::id() !== $post->user_id)  {{-- 自分自身でないかを確認 --}}
                        @if (Auth::user()->isFollowing($post->user_id))
                            <form method="POST" action="{{ route('unfollow', $post->user_id) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-secondary rounded-pill">フォロー中</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('follow', $post->user_id) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary rounded-pill">フォローする</button>
                            </form>
                        @endif
                    @elseif(!Auth::check())  {{-- ログインしていない場合 --}}
                        <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill">フォローする</a>
                    @endif
                </div>
            </div>
            <div class="">
                <div class="text-left d-inline-block w-75">
                    <p class="mb-2">{{ $post->post }}</p>
                    <p class="text-muted">{{ $post->created_at }}</p>
                </div>
                @if (Auth::id() === $post->user_id)
                    <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                        <form method="" action="">
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                        <a href="" class="btn btn-primary">編集する</a>
                    </div>
                @endif
            </div>
        </li>
    @endforeach
</ul>
<div class="m-auto" style="width: fit-content">
    {{ $posts->links('pagination::bootstrap-4') }}
</div>