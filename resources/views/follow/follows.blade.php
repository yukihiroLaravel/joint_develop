@extends('layouts.app')
@section('content')
<div class="row">
    @include('commons.common_users_show',['user' => $user])
    <div class="col-sm-8">
        @include('commons.common_tab',['user' => $user])
        @foreach ($follows as $follow)     
        <ul class="list-unstyled">
            <li class="mb-3 text-center">
                <div class="text-left d-inline-block w-75 mb-2">
                    <img class="mr-2 rounded-circle" src="{{ Gravatar::src ($follow->email,55) }}" alt="ユーザのアバター画像">
                    <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('users.show',$follow->id) }}">{{ $follow->name }}</a></p>
                </div>
            </li>
        </ul>
        @endforeach
        <div class="m-auto" style="width: fit-content">{{ $follows->links('pagination::bootstrap-4') }}</div>
    </div>
</div>
@endsection