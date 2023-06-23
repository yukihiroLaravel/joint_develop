<div class="card bg-info">
    <div class="card-header">
        <h3 class="card-title text-light">
            <i class="fas fa-user-alt"></i> {{ $user->name }}
        </h3>
    </div>
    <div class="card-body">
        <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 400) }}"
            alt="{{ $user->name }}アバター画像">
        @if ($user->id === Auth::id() )
            <div class="mt-3">
                <a href="{{ route('edit',Auth::id()) }}" class="btn btn-success btn-block">
                    <i class="fas fa-edit"></i> ユーザ情報の編集
                </a>
            </div>
        @else
        @endif
    </div>
</div>
@include('follow.follow_button')
