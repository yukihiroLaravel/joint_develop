<header class="mb-5">
    <nav class="navbar navbar-expand-sm navbar-dark bg-success">
        <a class="navbar-brand" href="/">Golffer</a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav">
            @if (Auth::check())
                <li class="nav-item"><a href="{{ route('users.show', Auth::id()) }}" class="nav-link text-light">{{ Auth::user()->name }}</a></li>
                <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link text-light">ログアウト</a></li>
            @else    
                <li class="nav-item"><a href="{{ route('loginform') }}" class="nav-link text-light">ログイン</a></li>
                <li class="nav-item"><a href="{{ route('signup') }}" class="nav-link text-light">新規ゴルファー登録</a></li>
            @endif
            </ul>
        </div>
    </nav>
</header>       