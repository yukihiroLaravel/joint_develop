<ul class="list-unstyled">
    @foreach ($posts as $post)
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $post->user_id) }}">{{ $post->user->name }}</a></p>
            </div>
            <div class="">
                <div class="text-left d-inline-block w-75">
                    <p class="mb-2">{{ $post->content }}</p>
                    <!-- 画像を選択していれば、画像が表示される -->
                    @if ($post->image !== null)
                        <img class="mb-2" src="{{ Storage::url($post->image) }}" alt="画像投稿">
                    @endif
                    <p class="text-muted">{{ $post->updated_at }}</p>
                </div>
                    <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                            <a href="{{ route('post.reply', $post->id) }}" class="btn btn-success">返信する({{ $post->replies->count() }})</a>
                        @if (Auth::id() === $post->user_id)
                            <div class="d-flex justify-content-start">
                                <a href="{{ route('post.edit', $post->id) }}" class="btn btn-primary">編集する</a>
                                <form method="POST" action="{{ route('post.delete', $post->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger ml-2">削除</button>
                                </form>
                                <!-- 画像を投稿していれば、ボタンが表示される -->
                                @if ($post->image !== null)
                                    <form method="POST" action="{{ route('image.delete', $post->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger ml-2">画像のみ削除</button>
                                    </form>
                                @endif
                            </div>
                        @endif
                    </div>
                
            </div>
        </li>
    @endforeach
</ul>
<div class="m-auto" style="width: fit-content">
{{ $posts->appends(['search' => request()->input('search', '')])->links('pagination::bootstrap-4') }}
</div>