{{-- 検索ワード入力 --}}
<div class="search-form-wrapper">
    <form action="{{ isset($user) ? route('users.show', ['id' => $user->id]) : route('top') }}" method="GET" class="form-inline my-2 my-lg-0 w-75 search-form">
        <input class="form-control mr-sm-2 " type="search" placeholder="検索キーワードを入力" aria-label="Search" name="keyword" value="{{ request('keyword') }}">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
            <i class="fas fa-search"></i> <!-- Font Awesomeの虫眼鏡アイコン -->
        </button>
    </form>
    <p class="search-description my-2 my-lg-0 w-75 text-muted">複数のキーワードを検索するには、スペースで区切って入力してください。</p> <!-- 説明を追加 -->
</div>
