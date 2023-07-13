<div class="card bg-info">
    <div class="card-header">
        <h3 class="card-title text-light">{{ $user->name }}</h3>
    </div>
    <div class="card-body">
        @if($user->profile_image)
            <img class="rounded-circle img-fluid" src="{{ asset('storage/uploads/' . $user->id . '/' . $user->profile_image) }}" alt="ユーザの画像" style="max-width: 150px; max-height: 150px; object-fit: contain;">
        @else
            <img class="rounded-circle img-fluid" src="{{ asset('storage/default-profile-image.png') }}" alt="デフォルトのプロフィール画像">
        @endif
        <div class="mt-3">
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
        </div>
        @include('users.follow_button')
    </div>
</div>