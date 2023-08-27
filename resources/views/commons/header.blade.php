<header class="mb-5">
    <nav class="navbar navbar-expand-sm navbar-dark bg-info">
        <a class="navbar-brand mr-5" href="/">Topic Posts</a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="d-flex justify-content-center w-75 m-auto">
            <form action="{{ route('posts.index') }}" method="GET">
                <input type="text" name="keyword" class="ml-5" placeholder="投稿内容の検索"  style="font-family: 'FontAwesome 5 Brands';" />
                <input type="submit" value="検索" >
            </form>
        </div>
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