<ul class="list-unstyled">
    @foreach ($posts as $post)
    <li class="mb-3 text-center">
        <div class="text-left d-inline-block w-75 mb-2">
                @if($post->user->profile_image)
                <img class="mr-2 mb-2 rounded-circle" src="{{ asset('storage/uploads/' . $post->user->id . '/' . $post->user->profile_image) }}" alt="ユーザの画像" style="max-width: 55px; max-height: 55px;">
                @else
                <img class="mr-22 mb-2 rounded-circle" src="{{ asset('storage/default-profile-images/' . getRandomDefaultProfileImage()) }}" alt="デフォルトのプロフィール画像" style="max-width: 55px; max-height: 55px;">
                @endif
                <p class="mt-3 mb-0 d-inline-block">出題：<a href="{{ route('user.show', $post->user->id) }}">{{ $post->user->name }}</a>さん</p>
            <div class="">
                <div class="text-left d-inline-block">
                    <p class="mb-2 h4">{{ $post->text }}</p>
                    <p class="text-muted">{{ $post->created_at }}</p>
                    @include('favorite.favorite_button')
                    <p class="mt-0 mb-4"><a href="{{ route('comment.show', $post->id) }}">このお題の回答ページ</a></p>
                </div>
                @if (Auth::id() === $post->user_id)
                <div class="d-flex justify-content-between pb-3 m-auto">
                    <form method="POST" action="{{ route('post.delete', $post->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">削除</button>
                    </form>
                    <a href="{{ route('post.edit', $post->id) }}" class="btn btn-primary">編集する</a>
                </div>
                @endif
            </div>
        </div>
    </li>
    @endforeach
</ul>