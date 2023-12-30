{{-- 簡易検索（入力フォーム） --}}
<div class="nav-item navbar-light ml-3">
    <form method="GET" action="{{ route('search.result') }}">
    @csrf
        <input type="text" name="searchContent" value="{{ $searchContent }}" placeholder="投稿内容">
        <input type="submit" value="検索">
    </form>
</div>
{{-- 詳細検索リンク --}}
<div class="nav-item">
    <a class="nav-link text-light" href="{{ route('search.form') }}">詳細検索</a>
</div >
