<!-- 共通レイアウト -->
<div class="card bg-info">
    <div class="card-header">
        <h3 class="card-title text-light">{{ $user->name }}</h3>
    </div>
    <div class="card-body">
        <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 308) }}" alt="ユーザのアバター画像">
        <div class="mt-3">
            <a href="{{ route('users.edit', ['id' => $user->id]) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
        </div>
        <div class="mt-4">
            <a href="{{ route('posts.show', ['id' => $user->id]) }}" class="btn btn-primary btn-block">投稿詳細</a>
        <div>
    </div>
</div>
<!-- ここにフォローボタンを挿入 -->
<div class="mt-3"> <!-- 20ピクセルの上マージンをBootstrapクラスで追加 -->
    @include('follow.follow_button', ['user' => $user])
</div>
