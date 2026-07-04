<ul class="list-unstyled">
    @forelse ($users as $listUser)
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                <img
                    class="mr-2 rounded-circle"
                    src="{{ Gravatar::src($listUser->email, 55) }}"
                    alt="{{ $listUser->name }}のアバター画像"
                >

                <p class="mt-3 mb-0 d-inline-block">
                    <a href="{{ route('user.show', $listUser->id) }}">
                        {{ $listUser->name }}
                    </a>
                </p>
            </div>
        </li>
    @empty
        <li class="text-center">
            {{ $emptyMessage ?? 'ユーザはいません。' }}
        </li>
    @endforelse
</ul>

<div class="m-auto" style="width: fit-content">
    {{ $users->links('pagination::bootstrap-4') }}
</div>