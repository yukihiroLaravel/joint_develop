<header class="mb-5">
    <nav class="navbar navbar-expand-sm navbar-dark bg-warning">
        <a class="navbar-brand" href="/"><img src="{{ asset('img/logo.png') }}" alt="ロゴ画像" width="40" height="40">Ideal Ramen</a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
                <ul class="navbar-nav">                    
                     @if (Auth::check())
                       <li class="nav-item"><a href="{{ route('user.show', Auth::id()) }}" class="nav-link text-light">{{ Auth::user()->name }}</a></li>
                       <li class="nav-item"><a href="{{ route('logout') }}"class="nav-link">ログアウト</a></li>                   
                     @else
                       <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">ログイン</a></li>
                       <li class="nav-item"><a href="{{ route('signup') }}" class="nav-link">新規ユーザ登録</a></li>
                     @endif
                </ul>       
        </div>
    </nav>
</header>
