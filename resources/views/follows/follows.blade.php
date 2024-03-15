<ul class="list-unstyled d-flex flex-column pt-3 pb-3  background-color_white col">
    @if ($usersList->count() == 0)
        <li class="mb-3 text-center">
            <p class="text-left d-inline-block w-75 mb-2">
                {{ Route::is('users.follow') ? 'フォローしているユーザーがいません。' : '' }}
                {{ Route::is('users.follower') ? 'フォロワーがいません。' : '' }}
            </p>
        </li>
    @else
        @foreach ($usersList as $item)
            <li class="mb-3 text-center">
                <div class="text-left d-inline-block w-75 mb-2">
                    <img class="mr-2 rounded-circle" src="{{ Gravatar::src($item->email, 55) }}" alt="ユーザのアバター画像">
                    <p class="mt-3 mb-0 d-inline-block"><a
                            href="{{ route('user.show', $item->id) }}">{{ $item->name }}</a>
                        @include('follows.follow_button', ['id' => $item->id])</p>
                </div>
            </li>
        @endforeach
        <div class="d-flex justify-content-center">
            {{ $usersList->links('pagination::bootstrap-4') }}
        </div>
    @endif
</ul>
