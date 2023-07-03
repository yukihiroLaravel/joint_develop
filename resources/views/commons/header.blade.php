<header class="mb-5">
    <nav class="navbar navbar-expand-sm navbar-dark bg-yellow">
        <a class="navbar-brand" href="/" style="color: black;">Topic Posts</a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav">
                @if (Auth::check())
                    <li class="nav-item"><a href="{{ route('user.show', Auth::id()) }}" class="nav-link text-dark">{{ Auth::user()->name}}</a></li>
                    <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link text-dark">ログアウト</a></li>
                @else
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-link text-dark">ログイン</a></li>
                    <li class="nav-item"><a href="{{ route('signup') }}" class="nav-link text-dark">新規ユーザ登録</a></li>
                @endif
            </ul>
        </div>
    </nav>
</header>