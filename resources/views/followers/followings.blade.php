<ul class="list-unstyled w-75 du-feed-list m-auto">
    @forelse($followings as $following)
        <li class="du-follow-list-item mb-3">
            <div class="d-flex align-items-center">
                {{-- design-update: 丸+頭文字のアイコンに変更 --}}
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
