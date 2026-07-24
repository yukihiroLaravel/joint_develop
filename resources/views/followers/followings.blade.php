<ul class="list-unstyled w-75 m-auto">
    @forelse($followings as $following)
        <li class="mb-3">
            <div class="d-flex align-items-center">
                {{-- design-update: Gravatarから、丸+頭文字のアバターに変更。Gravatar版はコメントアウトで残している --}}
                {{-- <img class="rounded-circle mr-3" src="{{ Gravatar::src($following->email, 55) }}" alt="{{ $following->name }}"> --}}
                <span class="du-avatar-initial du-follow-avatar mr-3 du-avatar-c{{ $following->id % 6 }}">{{ mb_substr($following->name, 0, 1) }}</span>
                <div>
                    <a href="{{ route('users.show', $following->id) }}" class="du-follow-name">{{ $following->name }}</a>
                </div>
            </div>
        </li>
    @empty
        <li class="text-center text-muted">
            フォロー中のユーザーはいません。
        </li>
    @endforelse
</ul>

<div class="d-flex justify-content-center">
    {{ $followings->links() }}
</div>
