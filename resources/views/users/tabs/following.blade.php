@if ($users->count())
    <ul class="list-group">
        @foreach ($users as $userItem)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('users.show', $userItem->id) }}">{{ $userItem->name }}</a>
                    <div class="small text-muted">{{ $userItem->profile ?? '' }}</div>
                </div>
                <div>
                    @auth
                        @if (auth()->id() !== $userItem->id)
                            @if (auth()->user()->isFollowing($userItem->id))
                                <form action="{{ route('users.unfollow', $userItem->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-secondary">フォロー解除</button>
                                </form>
                            @else
                                <form action="{{ route('users.follow', $userItem->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-sm btn-primary">フォローする</button>
                                </form>
                            @endif
                        @endif
                    @endauth
                </div>
            </li>
        @endforeach
    </ul>
    <div class="mt-3">{{ $users->appends(['tab' => 'following'])->links() }}</div>
@else
    <p>フォロー中のユーザーはいません。</p>
@endif