@php
    if (Route::is('users.follow')) {
        $relevantUsers = $user->followUsers;
    } elseif (Route::is('users.follower')) {
        $relevantUsers = $user->followerUsers;
    }
@endphp
<ul class="list-unstyled">
    @if ($relevantUsers->count() == 0)
        <li class="mb-3 text-center">
            <p class="text-left d-inline-block w-75 mb-2">
                {{ Route::is('users.follow') ? 'フォローしているユーザーがいません。' : '' }}
                {{ Route::is('users.follower') ? 'フォロワーがいません。' : '' }}
            </p>
        </li>
    @else
        @foreach ($relevantUsers as $relevantUser)
            <li class="mb-3 text-center">
                <div class="text-left d-inline-block w-75 mb-2">
                    <img class="mr-2 rounded-circle" src="{{ Gravatar::src($relevantUser->email, 55) }}" alt="ユーザのアバター画像">
                    <p class="mt-3 mb-0 d-inline-block"><a href="">{{ $relevantUser->name }}</a>
                        @include('follows.follow_button', ['id' => $relevantUser->id])</p>
                </div>
            </li>
        @endforeach
    @endif
</ul>
