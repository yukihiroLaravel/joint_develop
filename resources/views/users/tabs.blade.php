<ul class="nav nav-tabs nav-justified mb-3">
    <li class="nav-item">
        <a href="{{ route('users.show', $user->id) }}"
           class="nav-link {{ request()->routeIs('users.show') ? 'active' : '' }}">
           タイムライン
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('users.following', $user->id) }}"
           class="nav-link {{ request()->routeIs('users.following') ? 'active' : '' }}">
           フォロー中 <span class="badge badge-secondary">{{ $followingCount }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('users.followers', $user->id) }}"
           class="nav-link {{ request()->routeIs('users.followers') ? 'active' : '' }}">
           フォロワー <span class="badge badge-secondary">{{ $followersCount }}</span>
        </a>
    </li>
</ul>