<div class="col-sm-8">
    <ul class="nav nav-tabs nav-justified mb-3">
        <li class="nav-item">
            <a href="{{ route('user.show', $user->id) }}" class="nav-link {{ Route::is('user.show') && Request::is('users/'.$user->id) ? 'active' : '' }}">タイムライン<br><div class="badge badge-secondary">{{ isset($countPosts) ? $countPosts : 0 }}</div></a>
        </li>
        <li class="nav-item">
            <a href="{{ route('user.follows', $user->id) }}" class="nav-link {{ Route::is('user.follows') && Request::is('users/'.$user->id.'/follows') ? 'active' : '' }}">フォロー中<br><div class="badge badge-secondary">{{ isset($countFollows) ? $countFollows : 0 }}</div></a>
        </li>
        <li class="nav-item">
            <a href="{{ route('user.followers', $user->id) }}" class="nav-link {{ Route::is('user.followers') && Request::is('users/'.$user->id.'/followers') ? 'active' : '' }}">フォロワー<br><div class="badge badge-secondary">{{ isset($countFollowers) ? $countFollowers : 0 }}</div></a>
        </li>
    </ul>
    @include('posts.posts', ['user' => $user, 'posts' => $posts])
</div>