<h5 class="mt-5 mb-4">フォロワー</h5>
@foreach ($followers as $follower)
    <div class="list-group-item">
        <li class="media mb-2">
            <img class="mr-3 rounded-circle" 
                    src="{{ Gravatar::src($follower->email, 55) }}" alt="{{ $follower->name }}のアバター画像">
            <div class="media-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mt-0 mb-1"><a href="{{ route('user.show', $follower->id) }}">{{ $follower->name }}</a></h5>
                    @if (Auth::check() && Auth::id() !== $follower->id)  {{-- 自分自身でないかを確認 --}}
                        @if (Auth::user()->isFollowing($follower->id))
                            {{-- フォロー中ボタン --}}
                            <button type="button" 
                                    class="btn btn-outline-secondary rounded-pill follow-btn"
                                    data-follower-name="{{ $follower->name }}" 
                                    data-follower-id="{{ $follower->id }}">
                                <span>フォロー解除</span>
                                <span>フォロー中</span>
                            </button>
                            {{-- フォロー解除の確認ポップアップ --}}
                            <div id="confirm-unfollow" class="floating-confirm" style="display: none;">
                                <div class="confirm-content">
                                    <p><span id="unfollow-message"></span>さんをフォロー解除しますか？</p>
                                    <form method="POST" action="" id="unfollow-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">フォロー解除</button>
                                        <button type="button" class="btn btn-secondary" id="cancel-unfollow">キャンセル</button>
                                    </form>
                                </div>
                            </div>
                            {{-- グレーアウト用の背景 --}}
                            <div id="overlay" style="display: none;"></div>
                        @else
                            {{-- フォローするボタン --}}
                            <form method="POST" action="{{ route('follow', $follower->id) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-primary rounded-pill">フォローする</button>
                            </form>
                        @endif
                    @elseif (!Auth::check())  {{-- ログインしていない場合 --}}
                        <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill">フォローする</a>
                    @endif
                </div>
                <p class="mb-0 text-muted">{{ $follower->email }}</p>
            </div>
        </li>
    </div>
@endforeach
<div class="mt-3">
    {{ $followers->links('pagination::bootstrap-4') }}
</div>

<script src="{{ asset('/js/confirmUnfollow.js') }}" defer></script>
