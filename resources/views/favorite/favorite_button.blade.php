<div class="ml-2 text-right">
    @if (Auth::check() && Auth::id() !== $post->user_id) <!-- ユーザがログインしているかつ、投稿の所有者ではないことを確認 -->
        <div class="ml-auto">
            @if (Auth::user()->isFavorite($post->id)) <!-- 現在ログインしているユーザがこの投稿を既に「いいね！」しているかを確認 -->
                <form id="unfavorite-form-{{ $post->id }}" method="POST" action="{{ route('unfavorite', $post->id) }}" style="display: none;">
                    @csrf <!--  CSRF（クロスサイトリクエストフォージェリ）対策のためのトークン -->
                    @method('DELETE')
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('unfavorite-form-{{ $post->id }}').submit();" class="text-danger">
                    <i class="fas fa-heart"></i>
                </a>
            @else
                <form id="favorite-form-{{ $post->id }}" method="POST" action="{{ route('favorite', $post->id) }}" style="display: none;">
                    @csrf <!--  CSRF（クロスサイトリクエストフォージェリ）対策のためのトークン -->
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('favorite-form-{{ $post->id }}').submit();" class="text-secondary">
                    <i class="fas fa-heart"></i>
                </a>
            @endif
        </div>
    @endif
</div>
