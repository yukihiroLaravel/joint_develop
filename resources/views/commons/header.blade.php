<header class="mb-5">
    @csrf
    <nav class="navbar navbar-expand-sm navbar-dark bg-info">
        <a class="navbar-brand" href="/">Topic Posts</a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav"> 
            @if (Auth::check())
            <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link">ログアウト</a></li>
            <li class="nav-item"><a href="" class="nav-link">マイページ</a></li>
        @else
        </ul>
        </div>
    </nav>
</header>

