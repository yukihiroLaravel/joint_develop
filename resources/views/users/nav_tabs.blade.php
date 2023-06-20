<ul class="nav nav-tabs nav-justified mb-3">
    <li class="nav-item"><a href="{{ route('user.show', $user->id) }}" class="nav-link {{ Request::routeIs('user.show') ? 'active' : '' }}">タイムライン</a></li>
    <li class="nav-item"><a href="{{ route('user.following', $user->id) }}" class="nav-link {{ Request::routeIs('user.following') ? 'active' : '' }}">フォロー中</a></li>
    <li class="nav-item"><a href="{{ route('user.follower', $user->id) }}" class="nav-link {{ Request::routeIs('user.follower') ? 'active' : '' }}">フォロワー</a></li>
</ul>