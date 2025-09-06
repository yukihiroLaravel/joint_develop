@extends('layouts.app')
@section('content')
<div class="row">
    @include('users.profile')
    <div class="col-sm-8">
        @include('users.tabs')
        <h3 class="mt-3 mb-4 text-center" style="color:#2e5c2b; font-weight:bold;">
            <i class="fas fa-hiking"></i> あなたがフォローしているユーザ一覧
        </h3>
        @forelse ($followingUsers as $user)
            <div class="d-flex align-items-center justify-content-between p-3 mb-3 shadow-sm"
                 style="background:#f9f7f1; border:2px solid #8b5e3c; border-radius:15px;">
                <div class="d-flex align-items-center"> 
                    <img class="rounded-circle mr-3 border border-success"
                        src="{{ Gravatar::src($user->email, 60) }}"
                        alt="{{ $user->name }}"
                        style="width:60px; height:60px; object-fit:cover;">
                    <div>
                        <strong style="color:#2e5c2b;">{{ $user->name }}</strong>
                    </div>
                </div>
                <div>
                    @include('users.follow_button', ['user' => $user])
                </div>
            </div>
        @empty
            <p class="text-center mt-4" style="color:#555;">
                フォローしているユーザはいません。<br>
                気になる人をフォローしてみましょう！
            </p>
        @endforelse
        <div class="mt-4">
            {{ $followingUsers->links() }}
        </div>
    </div>
</div>
@endsection