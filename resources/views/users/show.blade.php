@extends('layouts.app')
@section('content')
    <h1>{{ $user->name }}</h1>
    <ul class="nav nav-tabs nav-justified mt-5 mb-2">
        <li class="nav-item nav-link {{ Request::is('users/'. $user->id) ? 'active' : '' }}"><a href="{{ route('user.show', $user->id) }}">使用者<br><div class="badge badge-secondary">{{ $countUsers }}</div></a></li>
        <li class="nav-item nav-link><a href="">お気に入り<br><div class="badge badge-secondary"></div></a></li>
    </ul>
    @include('users.users', ['user' => $user, 'users' => $users])
@endsection