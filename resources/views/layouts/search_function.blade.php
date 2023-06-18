<form method="GET" action="{{ route('posts.search') }}">
    <input type="search" placeholder="キーワードを入力" name="search" value="@if (isset($search)) {{ $search }} @endif">    
    <button type="submit">検索</button>
</form>