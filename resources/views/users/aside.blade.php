<aside class="col-sm-4 mb-5">
    <div class="card bg-info">
        <div class="card-header d-inline-block">
            <h3 class="card-title text-light">
                <i class="fas fa-user-circle"></i> {{ $user->name }}
                @include('follow.follow_button',['user'=> $user])
            </h3>
        </div>
        <div class="card-body">
            <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 400) }}" alt="ユーザーアバター画像">
            @if(Auth::id() === $user->id)
                <div class="mt-3">
                    <a href="{{route('user.edit', $user->id)}}" class="btn btn-primary btn-block">
                        <i class="fas fa-user-edit"></i> ユーザ情報の編集
                    </a>
                </div>
            @endif
        </div>
    </div>
</aside>