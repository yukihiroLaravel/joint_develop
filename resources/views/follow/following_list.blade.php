@foreach ($followingUsers as $followingUser )
    <ul class="list-unstyled">
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($followingUser->email, 55) }}" alt="{{ $followingUser->email }}のアバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $followingUser->id) }}">{{ $followingUser->name }}</a></p>
            </div>
            <div class="text-left d-inline-block w-75">
                <p class="mb-1">{{ $followingUser->posts->last()->text }}</p>
                <p class="text-muted">{{ $followingUser->posts->last()->updated_at }}</p>
            </div>
            @if (Auth::check() && Auth::id() === $user->id)
                <div class="d-inline-block w-50 mb-3">
                    @if (Auth::user()->isFollow($followingUser->id))
                        <form method="POST" action="{{ route('unfollow', $followingUser->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block">フォローを外す</button>
                        </form>
                    @endif
                </div>
            @endif
        </li>
    </ul>
@endforeach
<div class="m-auto" style="width: fit-content"></div>
{{ $followingUsers->links('pagination::bootstrap-4') }}
