<header class="mb-5">
    <nav class="navbar navbar-expand-sm navbar-dark bg-info">
<<<<<<< HEAD
        <a class="navbar-brand" href="/">オススメしたいお店を紹介しよう</a>
=======
        <a class="navbar-brand" href="/">Topic Posts</a>
        <form class="form-inline my-2 my-lg-0 ml-2" action="/" method="get">
            <div class="form-group">
                <input type="search" class="form-control mr-sm-2" name="search" value="{{request('search')}}" placeholder="投稿を検索" aria-label="検索...">
            </div>
            <input type="submit" value="検索" class="btn btn-primary">
        </form>
>>>>>>> develop_d_nagatsuki_rab
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav">
                @if (Auth::check())
                    <li class="nav-item"><a href="{{ route('user.show', Auth::id()) }}" class="nav-link">{{ Auth::user()->name }}</a></li>
                    <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link">ログアウト</a></li>
                @else
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">ログイン</a></li>
                    <li class="nav-item"><a href="{{ route('signup') }}" class="nav-link">新規ユーザ登録</a></li>
                @endif
            </ul>
        </div>
    </nav>
</header>

