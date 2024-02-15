<div>
    @php
        $id = $user->id;
    @endphp
    @if (Auth::check() && Auth::id() !== $id)
        @if (Auth::user()->isFollow($id))
            <form method="POST" action="{{ route('unfollow', $id) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-primary btn-block">フォロー解除</button>
            </form>
        @else
            <form method="POST" action="{{ route('follow', $id) }}">
                @csrf
                <button type="submit" class="btn btn-primary btn-block">フォローする</button>
            </form>
        @endif
    @endif
</div>
