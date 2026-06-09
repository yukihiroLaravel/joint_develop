@if (Auth::check() && Auth::id() !== $user->id)
    @if (Auth::user()->isFollowing($user->id))
        <form method="POST" action="{{ route('unfollow', $user->id) }}">
            @csrf
            @method('DELETE')
            <div class="mt-3">
                <button type="submit" class="btn-danger btn-block">フォロー解除する</a>
                <!-- <a href="" class="btn btn-danger btn-block">フォロー解除する</a> -->
            </div>
        </form>
    @else
        <form method="POST" action="{{ route('follow', $user->id) }}">
            @csrf
            <div class="mt-3">
                <button type="submit" class="btn btn-primary btn-block">フォローする</a>
                <!-- <a href="" class="btn btn-primary btn-block">フォローする</a> -->
            </div>
        </form>
    @endif
@endif