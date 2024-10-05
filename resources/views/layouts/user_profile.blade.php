<div class="card app-bg-color">
    <div class="card-header">
        <h3 class="card-title text-light">{{ $user->name }}</h3>
    </div>
    <div class="card-body mx-auto">
        <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 308) }}" alt="ユーザのアバター画像">
        <div class="mt-3">
            <!-- 認証されているユーザのIDが表示されているユーザのIDと一致する場合にのみ、「ユーザ情報の編集」ボタンを表示 -->
            @if (Auth::id() == $user->id)
                <a href="{{ route('users.edit', ['id' => $user->id]) }}" class="btn btn-primary btn-block border">ユーザ情報の編集</a>
            @endif
            @include('follow.follow_button', ['user' => $user]) <!-- フォローボタン -->
        </div>
    </div>
</div>
