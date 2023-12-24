{{-- 簡易検索（検索ワード入力フォーム） --}}
<div class="nav-link navbar-light ml-3">
    <form action="{{ route('post.index') }}" method="GET">
        <input type="text" name="keyword" value="{{ $keyword }}" placeholder="投稿内容">
        <input type="submit" value="検索">
    </form>
</div>
{{-- 詳細検索リンク --}}
<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link text-light" href="{{ route('search.index') }}">詳細検索</a>
    </li>
</ul>
