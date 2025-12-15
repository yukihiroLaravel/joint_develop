@forelse($followers as $person)
    <div class="d-flex align-items-center border p-2 mb-2">

        <img src="{{ Gravatar::src($person->email, 60) }}"
             class="rounded-circle mr-3">

        <div class="flex-grow-1">
            <a href="{{ route('user.show', $person->id) }}">
                {{ $person->name }}
            </a>
        </div>

        @if(Auth::check() && Auth::id() !== $person->id)
            @if(Auth::user()->followings->contains($person->id))
                <form action="{{ route('user.unfollow', $person->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">解除</button>
                </form>
            @else
                <form action="{{ route('user.follow', $person->id) }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-outline-primary">フォロー</button>
                </form>
            @endif
        @endif
    </div>
@empty
    <p>フォロワーはいません。</p>
@endforelse

{{ $followers->links() }}