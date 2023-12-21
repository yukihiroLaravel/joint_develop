{{-- 検索ワード入力 --}}
<form action="{{ route('post.index') }}" method="GET">
    <input type="text" name="keyword" value="{{ $keyword }}">
    <input type="submit" value="検索">
</form>
