@extends('layouts.app')
@section('content')
    <ul class="nav nav-tabs nav-justified mb-3">
        <li class="nav-item nav-link">フォロワー   {{ $count_followers }}</li>
    </ul>
    @foreach ($followers as $follower)
        <div class="text-left d-inline-block w-100 mb-2 card-header">
            <img class="mr-2 rounded-circle" src="{{ Gravatar::src($follower->email, 55) }}" alt="ユーザのアバター画像">
            <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $follower) }}">{{ $follower->name }}</a></p>
        </div>
    @endforeach
@endsection