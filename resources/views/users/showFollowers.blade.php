@foreach ($followers as $follower)
<ul class="list-unstyled">
    <li class="mb-3 text-center">
        <div class="text-left d-inline-block w-75 mb-2">
            <img class="mr-2 rounded-circle" src="{{ Gravatar::src($follower->email, 55) }}" alt="ユーザのアバター画像">
            <p class="mt-3 mb-0 d-inline-block"><a  href="{{ route('users.show', $follower->id) }}">{{ $follower->name }}</a></p>
            @include('follows.follow_button',['user'=> $follower])
         </div>
     </li>
</ul>
@endforeach
<div class="m-auto" style="width: fit-content">{{ $followers->links('pagination::bootstrap-4') }}</div>
