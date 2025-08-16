@extends('layouts.app')
@section('content')
<div class="row">
    @include('users.profile')

    <div class="col-sm-8">
        @include('users.tabs')

        @foreach ($followers as $u)
            <div class="media mb-3 align-items-center">
                <img class="rounded-circle mr-3" src="{{ Gravatar::src($u->email, 60) }}">
                <div class="media-body">
                    <strong>{{ $u->name }}</strong>
                </div>
                <div>
                    @include('users.follow_button', ['user' => $u])
                </div>
            </div>
        @endforeach

        {{ $followers->links() }}
    </div>
</div>
@endsection