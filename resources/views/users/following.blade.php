@extends('layouts.app')
@section('content')
<div class="row">
    @include('users.profile')

    <div class="col-sm-8">
        @include('users.tabs')

        @foreach ($followingUsers as $user)
            <div class="media mb-3 align-items-center">
                <img class="rounded-circle mr-3" src="{{ Gravatar::src($user->email, 60) }}">
                <div class="media-body">
                    <strong>{{ $user->name }}</strong>
                </div>
                <div>
                    @include('users.follow_button', ['user' => $user])
                </div>
            </div>
        @endforeach

        {{ $followingUsers->links() }}
    </div>
</div>
@endsection