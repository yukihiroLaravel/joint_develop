<ul class="nav nav-tabs nav-justified mb-3"
    style="background-color:#f9f7f1; border:2px solid #8b5e3c; border-radius:12px; overflow:hidden;">>
    <li class="nav-item">
        <a href="{{ route('users.show', $user->id) }}"
           class="nav-link {{ request()->routeIs('users.show') ? 'active' : '' }}"
           style="color:#2e5c2b; font-weight:bold;">
           タイムライン
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('users.following', $user->id) }}"
           class="nav-link {{ request()->routeIs('users.following') ? 'active' : '' }}"
           style="color:#2e5c2b; font-weight:bold;">
           フォロー中
           <span class="badge badge-success">{{ $followingCount }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('users.followers', $user->id) }}"
           class="nav-link {{ request()->routeIs('users.followers') ? 'active' : '' }}"
           style="color:#2e5c2b; font-weight:bold;">
           フォロワー
           <span class="badge badge-success">{{ $followersCount }}</span>
        </a>
    </li>
</ul>