<header class="mb-5">
    <nav class="navbar navbar-expand-sm navbar-dark" style="background-color: #556B2F">
        <a class="navbar-brand header-navbar-text" href="/"
            ><i class="fas fa-campground pr-1"></i>野営トーク</a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav">
                @if (Auth::check())
                    <li class="nav-item d-flex align-items-center">
                        <img class="mr-0 rounded-circle" src="{{ Gravatar::src(Auth::user()->email, 25) }}"
                            alt="ユーザのアバター画像">
                        <a href="{{ route('user.show', Auth::id()) }}" class="nav-link font-weight-bold header-navbar-text"
                            >{{ Auth::user()->name }}</a>
                    </li>
                    <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link header-navbar-text"
                            >ログアウト</a></li>
                @else
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-link header-navbar-text"
                            >ログイン</a></li>
                    <li class="nav-item"><a href="{{ route('signup') }}" class="nav-link header-navbar-text"
                            >新規ユーザ登録</a></li>
                @endif
            </ul>
        </div>
    </nav>
</header>
