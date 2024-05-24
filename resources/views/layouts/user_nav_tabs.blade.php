<ul class="nav nav-tabs nav-justified mb-3">
    <li class="nav-item">
        <a href="{{ route('users.show', $user->id) }}" class="nav-link {{ Request::routeIs('users.show') ? 'active' : '' }}">
            タイムライン
            <div class="badge badge-secondary">{{ $counts['countPosts'] }}</div>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('followings', $user->id) }}" class="nav-link {{ Request::routeIs('followings') ? 'active' : '' }}">
            フォロー中
            <div class="badge badge-secondary">{{ $counts['countFollowings'] }}</div>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('followers', $user->id) }}" class="nav-link {{ Request::routeIs('followers') ? 'active' : '' }}">
            フォロワー
            <div class="badge badge-secondary">{{ $counts['countFollowers'] }}</div>
        </a>
    </li>
</ul>
