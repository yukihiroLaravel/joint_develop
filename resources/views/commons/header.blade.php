<header class="sticky-top pb-5">
    <nav class="navbar navbar-expand-sm navbar-dark bg-info">
        <a class="navbar-brand" href="/">Topic Posts</a>
        <div class="search_btn"><i class="fas fa-search"></i></div>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav">
                @if (Auth::check())
                    <li class="nav-item"><a href="" class="nav-link text-light">{{ Auth::user()->name }}</a></li>
                    <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link text-light">ログアウト</a></li>
                @else
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-link text-light">ログイン</a></li>
                    <li class="nav-item"><a href="{{ route('signup') }}" class="nav-link text-light">新規ユーザ登録</a></li>
                @endif
            </ul>
        </div>
    </nav>
    <div class="pt-3 pb-3 search_form">
        <form method="GET" action="{{ route('search') }}" class="d-flex col-lg-6 col-8">
            @csrf
            <input type="text" name="search_word" value="{{ isset($search_word) ? $search_word : '' }}"
                class="form-control input-group-prepend" placeholder="検索する">
            <span class="input-group-btn input-group-append">
                <button type="submit" id="btn-search" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
            </span>
        </form>
    </div>
</header>
