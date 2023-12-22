<ul class="list-unstyled">
        <li class="mb-3 text-center">
            @foreach($followings as $user)
                <div class="text-left d-inline-block w-75 mb-2">
                    <img class="mr-2 rounded-circle" src="{{ Gravatar::src( $user->email , 55) }}" alt="ユーザのアバター画像">
                    <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $user->id) }}">{{$user->name}}</a></p>
                </div>
            @endforeach
        </li>
</ul>
<div class="m-auto" style="width: fit-content">{{ $followings->links('pagination::bootstrap-4') }}</div>
