{{-- 簡易検索（検索ワード入力フォーム） --}}
<div class="nav-item navbar-light ml-3">
    <form method="POST" action="{{ route('search.search') }}">
    @csrf
        <input type="text" name="param1" value="{{ $param1 }}" placeholder="投稿内容">
        <input type="submit" value="検索">
    </form>
</div>

{{-- 詳細検索リンク --}}
<div class="nav-item">
    <a class="nav-link text-light" href="{{ route('search.index') }}">詳細検索</a>
</div >
