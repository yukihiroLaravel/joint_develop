<ul class="nav nav-tabs nav-justified mb-3">
    <li class="nav-item nav-link {{ Request::is('users/'.$user->id) ? 'active' :'' }}"><a href="{{ route('users.show',$user->id) }}">タイムライン<br><div class="badge badge-secondary">{{$countPosts}}</div></a></li>
    <li class="nav-item nav-link {{ Request::is('users/'.$user->id.'/follows') ? 'active' :'' }}"><a href="{{ route('user.follows',$user->id) }}">フォロー中<br><div class="badge badge-secondary">{{$countFollows}}</div></a></li>
    <li class="nav-item nav-link {{ Request::is('users/'.$user->id.'/followers') ? 'active' :'' }}"><a href="{{ route('user.followers',$user->id) }}">フォロワー<br><div class="badge badge-secondary">{{$countFollowers}}</div></a></li>
</ul>