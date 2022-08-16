<h1>{{ $user->name }}</h1>
@include('follow.follow_button', ['user' => $user])
<ul>
    <li class="nav-item nav-link {{ Request::is('users/'. $user->id) ? 'active' : '' }}"><a href="{{ route('users.show',['user'=>$user->id]) }}">タイムライン</a></li>
    <li class="nav-item nav-link {{ Request::is('users/*/followings') ? 'active' : '' }}"><a href="{{ route('followings',['id'=>$user->id]) }}">フォロー中<br><div class="badge badge-secondary">{{ $count_followings }}</div></a></li>
    <li class="nav-item nav-link {{ Request::is('users/*/followers') ? 'active' : '' }}"><a href="{{ route('followers',['id'=>$user->id]) }}"><br><div class="badge badge-secondary">{{ $count_followers }}</div></a></li>

</ul>
