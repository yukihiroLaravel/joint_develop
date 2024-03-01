<div>
    <style>
    /* CSS */
    @import url(https://use.fontawesome.com/releases/v5.3.1/css/all.css);
    label {
        color: white;
    }
    .search-button {
        font-family: FontAwesome;
        color: #17A2B8;
        background: #fff;
        border-radius: 5px;
        border: none;
    }
    form {
        padding-right: 10px;
    }
    input {
        color: #3d3d3d;
        border: none;
        border-radius: 5px;
        padding-right: 10px;
    }
    </style>
    <form action="{{ route('posts.search') }}" method="GET">
        <label for="keyword">投稿を検索する</label>
        <input type="text" id="keyword" name="keyword" value="{{ $keyword ?? '' }}">
        <button class="search-button" type="submit">検索 <i class="fa fa-search" aria-hidden="true"></i></button>
    </form>
</div>