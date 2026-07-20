<ul class="list-unstyled">
    @forelse($followings as $following)
        <li class="mb-3">
            <div class="d-flex align-items-center">
                <img class="rounded-circle mr-3" src="{{ Gravatar::src($following->email, 55) }}" alt="{{ $following->name }}">
                <div>
                    <a href="{{ route('users.show', $following->id) }}">{{ $following->name }}</a>
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