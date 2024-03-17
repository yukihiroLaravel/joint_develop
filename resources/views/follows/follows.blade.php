<ul class="list-unstyled d-flex flex-column pt-3 pb-3  background-color_white col" style="gap:2rem;">
    @if ($usersList->count() == 0)
        <li class="col-10">
            <p class="text-left d-inline-block w-75 mb-0">
                {{ Route::is('users.follow') ? 'フォローしているユーザーがいません。' : '' }}
                {{ Route::is('users.follower') ? 'フォロワーがいません。' : '' }}
            </p>
        </li>
    @else
        @foreach ($usersList as $item)
            <li class="col-10">
                <div class="d-flex">
                    <div class="mr-2" style="width: 55px">
                        @include('commons.user_icon', ['user' => $item])
                    </div>
                    <p class="mt-3 mb-0 d-inline-block"><a
                            href="{{ route('user.show', $item->id) }}">{{ $item->name }}</a>
                        @include('follows.follow_button', ['id' => $item->id])</p>
                </div>
            </li>
        @endforeach
    @endif
</ul>
<div class="d-flex justify-content-center">
    {{ $usersList->links('pagination::bootstrap-4') }}
</div>
