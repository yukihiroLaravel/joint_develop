<ul class="list-unstyled">
    @foreach ($users as $listUser)
        <li class="media mb-3 align-items-center">
            <img class="mr-3 rounded-circle" src="{{ Gravatar::src($listUser->email, 55) }}" alt="ユーザのアバター画像">
            <div class="media-body">
                <a href="{{ route('users.show', $listUser->id) }}">{{ $listUser->name }}</a>
            </div>
            @if (Auth::check() && Auth::id() !== $listUser->id)
                @if (in_array($listUser->id, $followingIds))
                    <form method="POST" action="{{ route('user.unfollow', $listUser->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-dark rounded-pill btn-sm px-3">フォロー中</button>
                    </form>
                @else
                    <form method="POST" action="{{ route('user.follow', $listUser->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-dark rounded-pill btn-sm px-3">フォロー</button>
                    </form>
                @endif
            @endif
        </li>
    @endforeach
</ul>
{{ $users->links() }}