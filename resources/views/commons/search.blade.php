<div>
<link rel="stylesheet" href="styles.css">
    <form action="{{ route('posts.search') }}" method="GET">
        <label for="keyword" class="search-label">投稿を検索する</label>
        <input type="text" id="keyword" name="keyword" value="{{ $keyword ?? '' }}" class="search-input">
        <button class="search-button" type="submit">検索 <i class="fa fa-search" aria-hidden="true"></i></button>
    </form>
</div>