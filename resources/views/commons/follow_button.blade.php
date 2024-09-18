<div class="d-inline-block">
    @if (Auth::check() && Auth::id() !== $userId)  {{-- 自分自身でないかを確認 --}}
        @if (Auth::user()->isFollowing($userId))
            {{-- フォロー中ボタン --}}
            <button type="button" 
                    class="btn {{ $buttonClass ?? 'btn-outline-secondary' }} rounded-pill follow-btn"
                    data-follower-name="{{ $userName }}" 
                    data-follower-id="{{ $userId }}">
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
            <form method="POST" action="{{ route('follow', $userId) }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-primary rounded-pill">フォローする</button>
            </form>
        @endif
    @elseif(!Auth::check())  {{-- ログインしていない場合 --}}
        <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill">フォローする</a>
    @endif
</div>
