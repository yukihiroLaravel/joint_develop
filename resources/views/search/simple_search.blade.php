{{-- 簡易検索（入力フォーム） --}}
<div class="nav-item navbar-light ml-3">
    <form class="form-inline" method="GET" action="{{ route('search.index') }}">
        @csrf
        <input type="text" name="searchContent" value="{{ $searchContent ?? '' }}" placeholder="投稿内容" class="form-control form-control-sm rounded-3 mr-sm-1">
        <button type="submit" class="btn btn-light btn-sm">検索</button>
    </form>
</div>
{{-- 詳細検索リンク --}}
<div class="nav-item">
    <a class="nav-link text-light" href="{{ route('search.form') }}">詳細検索</a>
</div >
