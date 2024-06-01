<!-- 共通レイアウト -->
<div class="card bg-color">
    <div class="card-header">
        <h3 class="card-title text-light">{{ $user->name }}</h3>
    </div>
    <div class="card-body">
        <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 308) }}" alt="ユーザのアバター画像">
        <!-- 認証されているユーザーのIDが表示されているユーザーのIDと一致する場合にのみ、「ユーザ情報の編集」ボタンを表示 -->
        @if (Auth::id() == $user->id)
        <div class="mt-3">
            <a href="{{ route('users.edit', ['id' => $user->id]) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
        </div>
        @endif
    </div>
</div>
<!-- ここにフォローボタンを挿入 -->
<div class="mt-3"> <!-- 20ピクセルの上マージンをBootstrapクラスで追加 -->
    @include('follow.follow_button', ['user' => $user])
</div>
