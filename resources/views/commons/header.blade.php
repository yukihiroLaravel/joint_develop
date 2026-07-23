<!-- design-update: ミント配色のヘッダーに変更。左：テキストとロゴ表示。右：ログイン中は丸+頭文字のアバターを表示。画面上部に固定表示 -->
<!-- design-update: navbar-darkがないとハンバーガーアイコンの背景画像が表示されなかったため追加（白いアイコンになる） -->
<!-- design-update: 固定表示はBootstrap標準のfixed-topを使用し、影のみdu-header-shadowで追加 -->
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
                {{-- design-update: Gravatarから、丸+頭文字のアバターに変更。Gravatar版はコメントアウトで残しています --}}
                {{-- <img class="du-user-avatar" src="{{ Gravatar::src(Auth::user()->email, 32) }}" alt="ユーザのアバター画像"> --}}
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
