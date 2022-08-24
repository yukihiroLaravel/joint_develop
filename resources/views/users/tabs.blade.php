
    <ul class="nav nav-tabs nav-justified mb-3">
        <li class="nav-item nav-link"><a href="{{ route('user.show', $user->id) }}" class="{{ Request::is('user/'. $user->id) ? 'active' : '' }}">タイムライン</a></li>
        <li class="nav-item nav-link"><a href="{{ route('followings', $user->id) }}" class="{{ Request::is('users/'. $user->id. 'followings'. $user->id) ? 'active' : '' }}">フォロー<span class="ml-2">{{ $user->followings->count() }}</span></a></li>
        <li class="nav-item nav-link"><a href="{{ route('followers', $user->id) }}" class="{{ Request::is('users/'. $user->id. 'followers'. $user->id) ? 'active' : '' }}">フォロワー<span class="ml-2">{{ $user->followers()->count() }}</span></a></li>
    </ul>
    