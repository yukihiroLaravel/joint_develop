<header class="mb-5">
    <nav class="navbar navbar-expand-sm navbar-dark bg-warning">
        <a class="navbar-brand" href="/"><img src="{{ asset('img/logo.png') }}" alt="ロゴ画像" style="margin-right:8px; width:40px; height:40px;">Ideal Ramen</a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
                <ul class="navbar-nav">                    
					@if (Auth::check())
						<li class="nav-item">
							<a href="{{ route('user.show', Auth::id()) }}" class="nav-link text-light">
								<i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('logout') }}"class="nav-link">
								<i class="fas fa-sign-out-alt"></i> ログアウト
							</a>
						</li>                   
						@else
						<li class="nav-item">
							<a href="{{ route('login') }}" class="nav-link">
								<i class="fas fa-sign-out-alt"></i> ログイン
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('signup') }}" class="nav-link">
								<i class="fas fa-user-circle"></i> 新規ユーザ登録
							</a>
						</li>
					@endif
                </ul>       
        </div>
    </nav>
</header>
