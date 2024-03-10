<ul class="nav nav-tabs nav-justified mb-3">
    <li class="nav-item">
        <a href="{{ route('user.show', $user->id) }}" class="nav-link {{ Route::is('user.show') ? 'active' : '' }}">タイムライン<br>
        <div class="badge badge-secondary">{{ $countPosts }}
        </div>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('user.follows', $user->id) }}" class="nav-link {{ Route::is('user.follows') ? 'active' : '' }}">フォロー中<br>
        <div class="badge badge-secondary">{{ $countFollows }}
        </div>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('user.followers', $user->id) }}" class="nav-link {{ Route::is('user.followers') ? 'active' : '' }}">フォロワー<br>
        <div class="badge badge-secondary">{{ $countFollowers }}
        </div>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('user.favorites', $user->id) }}" class="nav-link {{ Route::is('user.favorites') ? 'active' : '' }}">お気に入り<br>
        <div class="badge badge-secondary">{{ $countFavorites }}
        </div>
        </a>
    </li>
</ul>