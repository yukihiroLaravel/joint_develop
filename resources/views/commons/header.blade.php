<header class="mb-5">
    <nav class="navbar navbar-expand-sm navbar-light" style="background-color: #d8f3dc;">
    <style>
        .navbar-light .navbar-brand {
            color: #557a6b !important; 
            font-weight: bold;
        }   

        .navbar-light .navbar-nav .nav-link {
            color: #557a6b !important; 
        }
        .navbar-light .navbar-nav .nav-link:hover {
            color: #111111 !important; 
        }
    </style>
        <a class="navbar-brand" href="/">Positive Oops</a>

        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>

            <ul class="navbar-nav">

                @if (Auth::check())
                    <li class="nav-item"><a href= "{{ route('user.show', Auth::id()) }}" class="nav-link text-light">マイページ：{{ Auth::user()->name }}</a></li>

                    @if (Auth::user()->is_admin)
                        <li class="nav-item"><a href="{{ route('admin.index') }}" class="nav-link text-light">管理者画面</a></li>
                    @endif

                    <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link text-light">ログアウト</a></li>
                @else
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-link text-light">
                    ログイン</a></li>

                    <li class="nav-item"><a href="{{ route('signup') }}" class="nav-link text-light">
                    新規ユーザ登録</a></li>
                @endif
            </ul>
        </div>
    </nav>
</header>