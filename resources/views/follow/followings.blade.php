@extends('layouts.app')
@section('content')
<div class="row">
    <aside class="col-sm-4 mb-5">
        @include('layouts.user_profile', ['user' => $user])
    </aside>
    <div class="col-sm-8">
        @include('layouts.user_nav_tabs', ['user' => $user, 'counts' => $counts])
        <ul class="list-unstyled">
            @foreach($followings as $following)
                <li class="mb-3 text-center">
                    <div class="text-left d-inline-block w-75 mb-2">
                        <img class="mr-2 rounded-circle" src="{{ Gravatar::src($following->email, 50) }}" alt="ユーザのアバター画像">
                        <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('users.show', $following->id) }}">{{ $following->name }}</a></p>
                    </div>
                </li>   
            @endforeach
        </ul> 
        <div class="m-auto" style="width: fit-content">{{ $followings->links('pagination::bootstrap-4') }}</div>
    </div>
</div>    
@endsection
