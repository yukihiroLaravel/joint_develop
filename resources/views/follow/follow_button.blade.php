 <!-- 自分自身をフォロー出来ない様にする記述 -->
 @if (Auth::check() && Auth::id() !== $user->id)
    <!-- 現在のユーザが対象のユーザをフォローしているかどうかを判断し、条件に応じて異なるフォームを表示 -->
    @if (Auth::user()->isFollowing($user->id))
        <form method="POST" action="{{ route('follow.destroy', $user->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">フォローを解除する</button>
        </form>
    @else
        <form method="POST" action="{{ route('follow.store', $user->id) }}">
            @csrf
            <button type="submit" class="btn btn-success">フォローをする</button>
        </form>
    @endif
@endif