<ul class="list-unstyled w-75 du-feed-list m-auto">
    @forelse($followers as $follower)
        <li class="mb-3">
            <div class="d-flex align-items-center">
                {{-- design-update: 丸+頭文字のアイコンに変更 --}}
                <span class="du-avatar-initial du-follow-avatar mr-3 du-avatar-c{{ $follower->id % 6 }}">{{ mb_substr($follower->name, 0, 1) }}</span>
                <div>
                    <a href="{{ route('users.show', $follower->id) }}" class="du-follow-name">{{ $follower->name }}</a>
                </div>
            </div>
        </li>
    @empty
        <li class="text-center text-muted">
            フォロワーはいません。
        </li>
    @endforelse
</ul>

<div class="d-flex justify-content-center">
    {{ $followers->links() }}
</div>