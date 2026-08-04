{{-- design-update: 左：テキストとロゴ表示。右：ログイン中は丸+頭文字アイコンを表示。画面上部に固定表示 --}}
<header class="fixed-top du-header-shadow">
    <nav class="navbar navbar-expand-sm navbar-dark du-header">
        <a class="navbar-brand du-logo du-font-title" href="/">今日のつぶやき<img src="/images/logo.svg" alt="今日のつぶやきロゴ" class="du-logo-mark"></a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav align-items-sm-center">
                @if (Auth::check())
                <li class="nav-item"><a href="{{ route('users.show', Auth::id()) }}" class="nav-link du-user-name"><span class="du-avatar-initial du-user-avatar du-avatar-c{{ Auth::id() % 6 }}">{{ mb_substr(Auth::user()->name, 0, 1) }}</span>{{ Auth::user()->name }}</a></li>
                <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link">ログアウト</a></li>
                @else
                <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">ログイン</a></li>
                <li class="nav-item"><a href="{{ route('signup') }}" class="nav-link">新規ユーザ登録</a></li>
                @endif
            </ul>
        </div>
    </nav>
</header>
