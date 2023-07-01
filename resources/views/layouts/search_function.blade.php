<form method="GET" action="{{ route('posts.search') }}">
    <input type="search" placeholder="キーワードを入力" name="search" value="@if (isset($search)) {{ $search }} @endif">    
    <button type="submit">検索</button>
</form>
<h8 class="text-center mb-3">複数のキーワードを検索したい場合は空白で区切って入力してください</h8>