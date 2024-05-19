{{-- 検索ワード入力 --}}
<form action="{{ route('top') }}" method="GET" class="form-inline my-2 my-lg-0 w-100">
    <input class="form-control mr-sm-2 w-75" type="search" placeholder="Search" aria-label="Search" name="keyword" value="{{ request('keyword') }}">
    <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">
        <i class="fas fa-search"></i> <!-- Font Awesomeの虫眼鏡アイコン -->
    </button>
</form>
