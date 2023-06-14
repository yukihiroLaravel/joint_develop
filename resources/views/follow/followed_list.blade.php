@extends('layouts.app')
@section('content')
    @include('commons.flash_message')
    <div class="row">
        <aside class="col-sm-4 mb-5">
            @include('commons.user_icon')
        </aside>
        <div class="col-sm-8">
            @include('commons.tab')
            @foreach ($followedUsers as $followedUser )
                <ul class="list-unstyled">
                    <li class="mb-3 text-center">
                        <div class="text-left d-inline-block w-75 mb-2">
                            <img class="mr-2 rounded-circle" src="{{ Gravatar::src($followedUser->email, 55) }}" alt="{{ $followedUser->email }}のアバター画像">
                            <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $followedUser->id) }}">{{ $followedUser->name }}</a></p>
                        </div>     
                    </li>
                </ul>
            @endforeach
            <div class="m-auto" style="width: fit-content">
            {{ $followedUsers->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection