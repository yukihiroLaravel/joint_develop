<header class="mb-5">
    <nav class="navbar navbar-expand-sm navbar-light fixed-top">
        <a class="navbar-brand text-light" href="/" style="font-family: 'Courier New', sans-serif; font-size: 24px;">Hobby Posts</a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav">
                @if (Auth::check())
                    <li class="nav-item"><a href="{{ route('user.show', Auth::user()->id) }}" class="nav-link text-white {{ Request::is('users/'. Auth::user()->id) ? 'active' : '' }}">{{ Auth::user()->name }}</a></li>
                    <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link text-white">ログアウト</a></li>
                @else
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-link text-white">ログイン</a></li>
                    <li class="nav-item"><a href="{{ route('signup') }}" class="nav-link text-white">新規ユーザ登録</a></li>
                @endif
            </ul>
        </div>
    </nav>
</header>