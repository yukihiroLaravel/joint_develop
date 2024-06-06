<div class="search-form-wrapper">
    <form action="{{ isset($user) ? route('users.show', ['id' => $user->id]) : route('top') }}" method="GET" class="form-inline my-2 my-lg-0 w-75 search-form">
        <input class="form-control mr-sm-2 " type="search" placeholder="キーワードを入力" aria-label="Search" name="keyword" value="{{ request('keyword') }}">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
            <i class="fas fa-search"></i> <!-- Font Awesomeの虫眼鏡アイコン -->
        </button>
    </form>
    <p class="search-description my-2 my-lg-0 w-75 text-muted">複数のキーワードで検索するには、スペースで区切って入力してください。</p> <!-- キーワード検索の補足説明 -->
</div>
