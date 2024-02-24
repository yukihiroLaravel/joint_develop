<div class="d-inline-block ml-3">
    @php
        $id = $user->id;
    @endphp
    @if (Auth::check() && Auth::id() !== $id)
        @if (Auth::user()->isFollow($id))
            <form method="POST" action="{{ route('unfollow', $id) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-secondary">フォロー解除&nbsp;<i class="fa fa-user-minus"></i></button>
            </form>
        @else
            <form method="POST" action="{{ route('follow', $id) }}">
                @csrf
                <button type="submit" class="btn" style="background-color: orange; color:white">フォローする&nbsp;<i
                        class="fa fa-user-plus" aria-hidden="true"></i></button>
            </form>
        @endif
    @endif
</div>
