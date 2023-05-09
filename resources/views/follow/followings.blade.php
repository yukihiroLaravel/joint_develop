@extends('layouts.app')
@section('content')  
 
<div class="row">
    <aside class="col-sm-4 mb-5">
        @include('commons.user_details_card', ['followUser' => $user])
        @include('users.follow_button', ['followUser' => $user])
    </aside>
    <div class="col-sm-8">
        @include('commons.user_details_tab', ['followUser' => $user])
        <ul class="list-unstyled">
            @foreach ($followings as $follow)
                <li class="mb-3 text-center">
                    <div class="text-left d-inline-block w-75 mb-2">
                        <img class="mr-2 rounded-circle" src="{{ Gravatar::src($follow->email, 55) }}" alt="ユーザのアバター画像">
                        <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('users.show',$follow->id) }}">{{$follow->name}}</a></p>
                    </div>
                </li>
            @endforeach
        </ul>
        <div class="m-auto" style="width: fit-content">{{ $followings->links('pagination::bootstrap-4') }}</div>
    </div>
 </div>
 @endsection




