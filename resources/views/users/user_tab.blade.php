<ul class="nav nav-tabs nav-justified mb-3">
    <li class="nav-item">
        <a href="{{ route('user.show', $user->id) }}" class="nav-link {{ Request::routeIs('user.show') ? 'active' : '' }}">お題の投稿<br>
            <div class="badge badge-secondary">{{ $countPosts }}</div>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('comments', $user->id) }}" class="nav-link {{ Request::routeIs('comments') ? 'active' : '' }}">回答の投稿<br>
            <div class="badge badge-secondary">{{ $countComments }}</div>
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
    <li class="nav-item">
        <a href="{{ route('favorites', $user->id) }}" class="nav-link {{ Request::routeIs('favorites') ? 'active' : '' }}">イイねしたお題<br>
            <div class="badge badge-secondary">{{ $countFavorites }}</div>
        </a>
    </li>
    <!-- <li class="nav-item nav-link"><a href="{{ route('favorites', $user->id) }}" class="{{ Request::is('users/'. $user->id. 'favorites'. $user->id) ? 'active' : '' }}">いいね<span class="ml-2 badge badge-success">{{ $countFavorites }}</span></a></li> -->
    <li class="nav-item">
        <a href="{{ route('comment.favorites', $user->id) }}" class="nav-link {{ Request::routeIs('comment.favorites') ? 'active' : '' }}">ワロタした回答<br>
            <div class="badge badge-secondary">{{ $countFavoritesComments }}</div>
        </a>
    </li>
</ul>

</ul>