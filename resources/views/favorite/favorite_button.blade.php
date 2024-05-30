<div class="col-md-3 text-right">
@if (Auth::check() && Auth::id() !== $post->user_id) <!-- ユーザーがログインしているかつ、投稿の所有者ではないことを確認 -->
    <div class="ml-auto d-flex ">
    @if (Auth::user()->isFavorite($post->id)) <!-- 現在ログインしているユーザーがこの投稿を既に「いいね！」しているかを確認 -->
        <form method="POST" action="{{ route('unfavorite', $post->id) }}" class="d-inline-block">
            @csrf <!--  CSRF（クロスサイトリクエストフォージェリ）対策のためのトークン -->
            @method('DELETE')
            <button type="submit" class="btn btn-danger">いいね！を外す</button>
        </form>
    @else
        <form method="POST" action="{{ route('favorite', $post->id) }}" class="d-inline-block">
            @csrf <!--  CSRF（クロスサイトリクエストフォージェリ）対策のためのトークン -->
            <button type="submit" class="btn btn-success">いいね！を押す</button>
        </form>
    @endif
@endif
</div>