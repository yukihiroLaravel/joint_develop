<div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav">
                @if (Auth::check())
                    <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link">ログアウト</a></li>
                    <li class="nav-item"><a href="" class="nav-link">マイページ</a></li>
                @else
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">ログイン</a></li>
                    <li class="nav-item"><a href="{{ route('signup') }}" class="nav-link">新規ユーザ登録</a></li>
                @endif
            </ul>
        </div>
    </nav>
</header>
@if(Auth::check())
    <p class="text-right mr-3 pb-3">
        ユーザー：<span class="user-name">{{ Auth::user()->name }}</span>
    </p>
@endif