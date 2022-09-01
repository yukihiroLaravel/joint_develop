<from method="GET" action="{{ route('posts.index') }}">
	<input type="search" placeholder="投稿を検索" name="search" value="@if (isset("search)) {{ $search }} @endif">
	<div>
		<button type="submit">検索</button>
	</div>
</form>

@foreach($posts as $post)

