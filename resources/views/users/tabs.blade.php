<ul>
    @foreach ($posts as $post)
    <li class="nav-item nav-link {{ Request::is('users/', $user->id) ? 'active' : '' }}"><a href="{{ route('user.show', [$post->user->id]) }}">タイムライン</a></li>
    @endforeach
    <li class="nav-item nav-link {{ Request::is('users/*/followings') ? 'active' : '' }}"><a href="{{ route('followings',['id'=>$user->id]) }}">フォロー中<br><div class="badge badge-secondary">{{ $count_followings }}</div></a></li>
    <li class="nav-item nav-link {{ Request::is('users/*/followers') ? 'active' : '' }}"><a href="{{ route('followers',['id'=>$user->id]) }}">フォロワー<br><div class="badge badge-secondary">{{ $count_followers }}</div></a></li>
</ul>
