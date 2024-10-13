<header class="mb-5">
    <nav class="navbar navbar-expand-sm navbar-dark bg-info">
        <a class="navbar-brand" href="/">{{ config('app.TopicPostsTitle') }}</a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav">

                @unless (Request::routeIs('signup') || Request::routeIs('login'))
                    <li class="nav-item" id="nav-item-search">
                        <form method="GET" action="{{ route('post.search')}}" id="search-form">
                            <div class="form-group m-0">
                                <div id="search-bar" class="form-control form-control-sm d-flex align-items-center p-0">
                                    <label for="search" class="text-dark px-2 m-0"><i class="fas fa-search"></i></label>
                                    <input id="search" type="search" name="q" value="{{ request('q') }}" placeholder="検索" autocomplete="off" class="flex-grow-1">
                                </div>
                            </div>
                        </form>
                    </li>
                @endunless

                @if (Auth::check())
                    <li class="nav-item"><a href="{{ route('user.show', Auth::id()) }}" class="nav-link text-light">{{ Auth::user()->name }}</a></li>
                    <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link text-light">ログアウト</a></li>
                @else
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-link text-light">ログイン</a></li>
                    <li class="nav-item"><a href="{{ route('signup') }}" class="nav-link text-light">新規ユーザ登録</a></li>
                @endif
            </ul>
        </div>
    </nav>
    @include('commons.flash_messages')
    @include('commons.flash_client_message')
</header>
