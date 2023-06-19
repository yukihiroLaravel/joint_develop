<ul class="nav nav-tabs nav-justified mb-3">
    <li class="nav-item">
        <a href="{{ route('user.show', $user->id) }}" class="nav-link {{ Request::routeIs('user.show') ? 'active' : '' }}">タイムライン<br>
            <div class="badge badge-secondary">{{ $countPosts }}</div>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('followings', $user->id) }}" class="nav-link {{ Request::routeIs('followings') ? 'active' : '' }}">フォロー中<br>
            <div class="badge badge-secondary">{{ $countFollowings }}</div>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('followers', $user->id) }}" class="nav-link {{ Request::routeIs('followers') ? 'active' : '' }}">フォロワー<br>
            <div class="badge badge-secondary">{{ $countFollowers }}</div>
        </a>
    </li>
</ul>