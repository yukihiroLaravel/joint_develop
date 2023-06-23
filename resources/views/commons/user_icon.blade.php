<div class="card bg-info">
    <div class="card-header">
        <h3 class="card-title text-light">{{ $user->name }}</h3>
    </div>
    <div class="card-body">
        @if ($user->profile_image === null)
            <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 400) }}"
                alt="{{ $user->name }}プロフィール画像">
        @else
            <img class="rounded-circle img-fluid" src="{{ asset('storage/images/profiles/'.$user->profile_image) }}"
                alt="{{ $user->name }}プロフィール画像" width="100%" height="auto">
        @endif
        @if ($user->id === Auth::id() )
            <div class="mt-3">
                <a href="{{ route('edit',Auth::id()) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
            </div>
        @else
        @endif
    </div>
</div>
@include('follow.follow_button')