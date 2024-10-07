<header class="mb-5">
    <nav class="navbar navbar-expand-sm navbar-dark bg-info">
        <a class="navbar-brand" href="/">Topic Posts</a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav">
              @if (Auth::check())
                  <li class="nav-item"><a href="{{ route('user.show', Auth::id()) }}" class="nav-link text-light">{{ Auth::user()->name }}</a></li>
                  <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link text-light">ログアウト</a></li>
              @else
                  <li class="nav-item"><a href="{{ route('login') }}" class="nav-link text-light">ログイン</a></li>
                  <li class="nav-item"><a href="{{ route('signup') }}" class="nav-link text-light">新規ユーザ登録</a></li>
              @endif
                  <li class="nav-item">
                      <form action="{{ route('index') }}" method="GET" class="form-inline my-2 my-lg-0 ml-2">
                        <input type="search" name="keyword" class="form-control mr-sm-2" value="{{ request('keyword') }}" placeholder="キーワードを入力" aria-label="検索">
                        <button class="btn btn-outline-success my-2 my-sm-0 search-button" type="submit">投稿を検索</button>
                      </form>
                  </li>
            </ul>
        </div>
    </nav>
</header>
