<div class="mt-3 text-left">
    @if (Auth::id() == $user->id)
        <!--  自分のページ：現在のプロフィール文を常に表示 -->
        <div class="profile-content mb-2">
            @if($user->profile)
                <div class="p-2 border rounded bg-white shadow-sm">
                    <p class="mb-0 small text-dark" style="white-space: pre-wrap;">{{ $user->profile }}</p>
                </div>
            @else
                <p class="text-muted small italic mb-2">プロフィールが設定されていません。</p>
            @endif
        </div>

        <!-- エラーメッセージの表示（500文字超え） -->
        @if ($errors->has('profile'))
            <div class="alert alert-danger small p-2 mb-2">
                <i class="fas fa-exclamation-triangle"></i> {{ $errors->first('profile') }}
            </div>
        @endif

        <!-- 編集フォーム（details) -->
        <details class="profile-edit-toggle" {{ $errors->has('profile') ? 'open' : '' }}>
            <!-- ボタンを常に見えるようにBootstrapのクラスを適用 -->
            <summary class="btn btn-light btn-sm btn-block shadow-sm mb-2 text-info font-weight-bold">
                <span class="edit-text"><i class="fas fa-edit"></i> プロフィールを編集する</span>
                <span class="close-text"><i class="fas fa-times"></i> 編集を閉じる</span>
            </summary>

            <div class="mt-2 p-3 border rounded bg-light shadow-inner">
                <form action="{{ route('user.update_profile', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label class="small font-weight-bold text-muted">自己紹介文 (500文字以内)</label>
                        <textarea name="profile" class="form-control form-control-sm {{ $errors->has('profile') ? 'is-invalid' : '' }}" rows="5">{{ old('profile', $user->profile) }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-success btn-sm btn-block shadow-sm">
                        更新を保存する
                    </button>
                </form>
            </div>
        </details>

    @else
        <!-- 他人のページ：設定されている場合のみ表示 -->
        @if($user->profile)
            <div class="p-2 border rounded bg-white shadow-sm">
                <p class="mb-0 small text-dark" style="white-space: pre-wrap;">{{ $user->profile }}</p>
            </div>
        @endif
    @endif
</div>

<style>
    .profile-edit-toggle summary {
        display: block;
        list-style: none;
        cursor: pointer;
        outline: none;
        /* 背景が bg-info の中でも目立つように設定 */
        border: 1px solid #dee2e6; 
    }
    .profile-edit-toggle summary::-webkit-details-marker {
        display: none;
    }

    .profile-edit-toggle .close-text { display: none; }

    /* 展開時（open）の見た目 */
    .profile-edit-toggle[open] .edit-text { display: none; }
    .profile-edit-toggle[open] .close-text { display: inline; }
    
    .profile-edit-toggle[open] summary {
        background-color: #e9ecef !important; /* 少しグレーにして「押した感」を出す */
        color: #000 !important;
        border-color: #ced4da;
    }

    /* ホバー時（カーソルを当てた時）の挙動も一応定義 */
    .profile-edit-toggle summary:hover {
        background-color: #f8f9fa;
        opacity: 0.9;
    }
</style>
