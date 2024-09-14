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
                            {{-- フォロー中ボタン --}}
                            <button type="button" 
                                    class="btn btn-outline-secondary rounded-pill follow-btn"
                                    data-follower-name="{{ $following->name }}" 
                                    data-follower-id="{{ $following->id }}">
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
                            <form method="POST" action="{{ route('follow', $following->id) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-primary rounded-pill">フォローする</button>
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

<script src="{{ asset('/js/confirmUnfollow.js') }}" defer></script>