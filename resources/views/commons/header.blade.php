<header class="mb-5">
    <nav class="navbar navbar-expand-sm navbar-light">
        <a class="navbar-brand" href="/">
            <i class="fas fa-tree"></i>
            <span class="brand-text">エンジニアの森</span>
            <i class="fas fa-tree"></i>
        </a>
        
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav ml-auto"> {{-- mr-autoをml-autoにするとメニューが右に寄ります --}}
                @if(Auth::check())
                    <li class="nav-item"><a href="/users/{{ Auth::id() }}" class="nav-link">{{ Auth::user()->name }}</a></li>
                    <li class="nav-item"><a href="/logout" class="nav-link">ログアウト</a></li>
                @else
                    <li class="nav-item"><a href="/login" class="nav-link">ログイン</a></li>
                    <li class="nav-item"><a href="/signup" class="nav-link">新規ユーザ登録</a></li>
                @endif
            </ul>
        </div>
    </nav>
</header>
