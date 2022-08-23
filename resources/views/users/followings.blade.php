@extends('layouts.app')
@section('content')
    <ul class="nav nav-tabs nav-justified mb-3">
        <li class="nav-item nav-link">フォロー中    {{ $count_followings }}</li>
    </ul>
    @foreach ($followings as $following)
        <div class="text-left d-inline-block w-100 mb-2 card-header">   
            <img class="mr-2 rounded-circle" src="{{ Gravatar::src($following->email, 55) }}" alt="ユーザのアバター画像">
            <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $following) }}">{{ $following->name }}</a></p>
        </div>
    @endforeach
@endsection