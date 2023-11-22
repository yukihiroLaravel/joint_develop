@foreach ($followings as $following)
<ul class="list-unstyled">
    <li class="mb-3 text-center">
        <div class="text-left d-inline-block w-75 mb-2">
            @if (isset($following->profile_image) && $following->profile_image)                
                <img class="rounded-circle img-fluid" src="{{ asset('storage/profile_images/' . $following->profile_image) }}" alt="ユーザーのプロフィール画像" style="width: 70px; height: 70px; border-radius: 50%; object-fit: cover;">
            @else
                <img class="rounded-circle img-fluid" src="{{ Gravatar::src($following->email, 55) }}" alt="ユーザのアバター画像">
            @endif            
            <p class="mt-3 mb-0 d-inline-block"><a  href="{{ route('users.show', $following->id) }}">{{ $following->name }}</a></p>
            @include('follows.follow_button',['user'=> $following])
        </div>
    </li>
</ul>
@endforeach
<div class="m-auto" style="width: fit-content">{{ $followings->links('pagination::bootstrap-4') }}</div>