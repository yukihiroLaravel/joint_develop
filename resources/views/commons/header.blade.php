<header class="mb-5">
    <nav class="navbar navbar-expand-sm navbar-dark bg-info">
        <a class="navbar-brand" href="/">Topic Posts</a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav-bar">
            <form method="GET" action="{{ url('/') }}" class="form-inline mx-auto my-2 my-sm-0">
                <input type="search" name="keyword" value="{{ request('keyword') }}" class="form-control form-control-sm mr-2" placeholder="投稿を検索" aria-label="投稿を検索">
                <button type="submit" class="btn btn-light btn-sm">検索</button>
            </form>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ route('ranking.show') }}" class="nav-link text-light">いいね!ランキング</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                @if (Auth::check())
                    <li class="nav-item">
                        <a href="{{ route('users.show', Auth::id()) }}" class="nav-link text-light">{{ Auth::user()->name }}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link text-light">ログアウト</a>
                    </li>
                @else
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-link text-light">ログイン</a></li>
                    <li class="nav-item"><a href="{{ route('signup') }}" class="nav-link text-light">新規ユーザ登録</a></li>
                @endif
            </ul>
        </div>
    </nav>
</header>
