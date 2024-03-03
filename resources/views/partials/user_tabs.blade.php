<ul class="nav nav-tabs nav-justified mb-3">
    <li class="nav-item">
        <a href="{{ route('user.show', $user->id) }}" class="nav-link {{ Route::is('user.show') ? 'active' : '' }}">タイムライン<br><div class="badge badge-secondary">{{ isset($countPosts) }}</div></a>
    </li>
    <li class="nav-item">
        <a href="{{ route('user.follows', $user->id) }}" class="nav-link {{ Route::is('user.follows') ? 'active' : '' }}">フォロー中<br><div class="badge badge-secondary">{{ isset($countFollows) }}</div></a>
    </li>
    <li class="nav-item">
        <a href="{{ route('user.followers', $user->id) }}" class="nav-link {{ Route::is('user.followers') ? 'active' : '' }}">フォロワー<br><div class="badge badge-secondary">{{ isset($countFollowers) }}</div></a>
    </li>
</ul>