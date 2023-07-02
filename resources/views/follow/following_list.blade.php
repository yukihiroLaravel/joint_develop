@extends('layouts.app')
@section('content')
    @include('commons.flash_message')
    <div class="row">
        <aside class="col-sm-4 mb-5">
            @include('users.user_icon')
        </aside>
        <div class="col-sm-8">
            @include('commons.tab')
            @foreach ($followingUsers as $followingUser )
                <ul class="list-unstyled">
                    <li class="mb-3 text-center flex-box">
                        <div class="text-left d-inline-block w-75 mb-2">
                            <img class="mr-2 rounded-circle" src="{{ Gravatar::src($followingUser->email, 55) }}" alt="{{ $followingUser->email }}のアバター画像">
                            <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $followingUser->id) }}">{{ $followingUser->name }}</a></p>
                        </div>
                        @if (Auth::check() && Auth::id() === $user->id)
                            <div class="w-50 mb-2 follow-button">
                                @if (Auth::user()->isFollow($followingUser->id))
                                    <form method="POST" action="{{ route('unfollow', $followingUser->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-block">
                                            <i class="fas fa-user-minus"></i> フォロー解除
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endif
                    </li>
                </ul>
            @endforeach
            <div class="m-auto" style="width: fit-content">
            {{ $followingUsers->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection