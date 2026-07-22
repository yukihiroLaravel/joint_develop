<ul class="list-unstyled">
    @forelse($followers as $follower)
        <li class="mb-3">
            <div class="d-flex align-items-center">
                <img class="rounded-circle mr-3" src="{{ Gravatar::src($follower->email, 55) }}" alt="{{ $follower->name }}">
                <div>
                    <a href="{{ route('users.show', $follower->id) }}">{{ $follower->name }}</a>
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