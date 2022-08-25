@extends('layouts.app')
@section('content')
    <div class="row">
        @include('users.users',['users'=>$users])
        <div class="col-sm-8">
            @include('users.tabs',['user'=>$user])
            @foreach ($users as $user)
                <div class="text-left d-inline-block w-100 mb-2 card-header">
                    <img class="mr-2 rounded-circle" src="{{ Gravatar::src($user->email, 55) }}" alt="ユーザのアバター画像">
                    <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $user) }}">{{ $user->name }}</a></p>
                </div>
            @endforeach
        </div>
    </div>
@endsection