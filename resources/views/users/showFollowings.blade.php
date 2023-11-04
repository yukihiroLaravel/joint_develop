@foreach ($followings as $following)
<ul class="list-unstyled">
    <li class="mb-3 text-center">
        <div class="text-left d-inline-block w-75 mb-2">
            @if (isset($user) && $user->profile_image)
                <img class="rounded-circle img-fluid" src="{{ asset('storage/images/' . $user->profile_image) }}" alt="ユーザーのプロフィール画像">
            @else
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($following->email, 55) }}" alt="ユーザのアバター画像">
            @endif            
            <p class="mt-3 mb-0 d-inline-block"><a  href="{{ route('users.show', $following->id) }}">{{ $following->name }}</a></p>
            @include('follows.follow_button',['user'=> $following])
        </div>
    </li>
</ul>
@endforeach
<div class="m-auto" style="width: fit-content">{{ $followings->links('pagination::bootstrap-4') }}</div>