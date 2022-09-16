<div class="search_box">
	<form method="GET" action="{{ route('post.search') }}">	
		<input type="search" placeholder="投稿を検索" name="search" value="@if (isset($search)) {{ $search }} @endif">
		<button type="submit">検索</button>
	</form>
</div>