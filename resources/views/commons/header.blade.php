<header class="mb-5">
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <a class="navbar-brand" href="/">
            <img src="{{ asset('images/tokyo-DeafLympic2025_Emblem.jpg') }}"
             alt="デフリンピック エンブレム"
             style="height: 32px;"
             class="mr-2">

            TOKYO 2025 デフリンピック<br>&ensp;×コミュニケーション</a>
        
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
        </div>
    </nav>
</header>