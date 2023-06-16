@extends('layouts.app')
@section('content')
<div class="row">
    <aside class="col-sm-4 mb-5">
        @include('users.user_card', ['followUser'=>$user])
    </aside>
    <div class="col-sm-8">
        @include('users.user_tab')
        <ul class="list-unstyled">
            @foreach ($followings as $follow)
            <li class="mb-3 text-center">
                <div class="text-left d-inline-block w-75 mb-2">
                    <img class="mr-2 rounded-circle" src="{{ Gravatar::src($follow->email, 55) }}" alt="ユーザのアバター画像">
                    <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show',$follow->id) }}">{{$follow->name}}</a></p>
                    @if (Auth::check() && Auth::id() !== $follow->id)
                    <form method="POST" action="{{ route('unFollow', $follow->id) }}" class="d-inline-block ml-4">
                        @csrf
                        @method('DELETE')
                        <div class="mt-3">
                            <button type="submit" class="btn btn-danger">フォロ―を外す</button>
                        </div>
                    </form>
                    @endif
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection