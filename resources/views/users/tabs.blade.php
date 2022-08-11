<h1>{{ $user->name }}</h1>
@include('follow.follow_button', ['user'=> $user])
<ul class="nav nav-tabs nav-justified mt-5 mb-2">
    <li class="nav-item nav-link {{ Request::is('users/'. $user->id) ? 'active' : '' }}"><a href="{{ route('users.show',['user'=>$user->id]) }}" class="">タイムライン</a></li>
    <li class="nav-item nav-link {{ Request::is('users/*/followers') ? 'active' : '' }}"><a href="{{ route('followers',['id'=>$user->id]) }}">フォロー<br><div class="badge badge-secondary">{{ $count_followers }}</div></a></li>
    <li class="nav-item nav-link {{ Request::is('users/*followings') ? 'active' : '' }}"><a href="{{ route('followings',['id'=>$user->id]) }}">フォロワー<br><div class="badge badge-secondary">{{ $count_followings }}</div></a></li>
</ul>