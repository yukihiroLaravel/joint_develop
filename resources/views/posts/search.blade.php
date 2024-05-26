{{-- 検索ワード入力 --}}
<form action="{{ isset($user) ? route('users.show', ['id' => $user->id]) : route('top') }}" method="GET" class="form-inline my-2 my-lg-0 w-75 search-form"><!-- w-100をw-75に修正 -->
    <input class="form-control mr-sm-2 " type="search" placeholder="検索キーワードを入力" aria-label="Search" name="keyword" value="{{ request('keyword') }}">
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
        <i class="fas fa-search"></i> <!-- Font Awesomeの虫眼鏡アイコン -->
    </button>
</form>
