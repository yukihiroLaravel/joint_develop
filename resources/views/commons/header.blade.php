<header class="mb-5">
    <nav class="navbar navbar-expand-sm navbar-dark bg-info">
        <a class="navbar-brand" href="/">Topic Posts</a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav-bar">
            <form method="GET" action="{{ route('posts.index') }}" class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" name="keyword" placeholder="投稿を検索" aria-label="Search" value="{{ request('keyword') }}">
                <button class="btn btn-outline-light my-2 my-sm-0" type="submit">検索</button>
            </form>
            <ul class="navbar-nav ml-auto">
                @if(Auth::check())
                    <li class="nav-item"><a href="{{ route('users.show', Auth::id()) }}" class="nav-link text-light">{{ Auth::user()->name }}</a></li>
                    <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link text-light">ログアウト</a></li>
                @else
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-link text-light">ログイン</a></li>
                    <li class="nav-item"><a href="{{ route('signup') }}" class="nav-link text-light">新規ユーザ登録</a></li>
                @endif
            </ul>
        </div>
    </nav>
</header>