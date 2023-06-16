<div class="card bg-info">
    <div class="card-header">
        <h3 class="card-title text-light">{{$user->name}}</h3>
    </div>
    <div class="card-body">
        <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 400) }}" alt="ユーザの画像">
        <div class="mt-3">
            <a href="" class="btn btn-primary btn-block">ユーザ情報の編集</a>
        </div>
        @include('users.follow_button', ['followUser'=>$user])
    </div>
</div>