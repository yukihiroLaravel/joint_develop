@extends('layouts.template')
@section('tab')
<ul class="list-unstyled">
    @foreach($follows as $follow)
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($follow->email, 55) }}" alt="ユーザのアバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('users.show', $follow->id) }}">{{ $follow->name }}</a></p>
            </div>
            @if (Auth::id() === $user->id && !Auth::user()->followCheck($follow->id))
                <div class="">
                    <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                        <form method="POST" action="{{ route('follow', $follow->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">フォローする</button>
                        </form>
                    </div>
                </div>
            @endif
        </li>
    @endforeach
</ul>
@endsection