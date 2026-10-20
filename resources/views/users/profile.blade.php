<aside class="col-sm-4 mb-5">
    <div class="card bg-info">
        <div class="card-header">
            <h3 class="card-title text-light">{{ $user->name }}</h3>
        </div>
        <div class="card-body text-center">
            <img class="rounded-circle w-75" src="{{ Gravatar::src($user->email, 300) }}" alt="ユーザのアバター画像">
            {{-- フォローボタン(自分以外のユーザ詳細ページにのみ表示) --}}
            @if (Auth::check() && Auth::id() !== $user->id)
                <div class="mt-3">
                    @if (Auth::user()->isFollowing($user->id))
                        <form method="POST" action="{{ route('user.unfollow', $user->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-light rounded-pill px-4 font-weight-bold">フォロー中</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('user.follow', $user->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-light rounded-pill px-4 font-weight-bold">フォロー<i class="fas fa-user-plus ml-2"></i></button>
                        </form>
                    @endif
                </div>
            @endif
            <div class="mt-3">
                <a href="#" class="btn btn-primary btn-block">ユーザ情報の編集</a>
            </div>
            {{-- 一時的にユーザ詳細画面に退会ボタンを表示 --}}
            @if (Auth::id() === $user->id)
                <button type="button" class="btn btn-danger btn-block mt-3" data-toggle="modal" data-target="#withdrawModal">退会する</button>

                <div class="modal fade" id="withdrawModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header"><h5 class="modal-title">確認</h5></div>
                            <div class="modal-body">本当に退会しますか？</div>
                            <div class="modal-footer justify-content-between">
                                <form method="POST" action="{{ route('user.destroy', $user->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-block">退会する</button>
                                </form>
                                <button type="button" class="btn btn-link text-dark" data-dismiss="modal">閉じる</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</aside>