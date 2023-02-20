@if (Auth::user() && Auth::id() !== $user->follow_id)
    @if (Auth::user()->isFollow($user->id))
        <form method="post" action="{{ route('unFollow', $user->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">フォローを外す</button>
            