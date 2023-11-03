@foreach ($posts as $post)    
    <ul class="list-unstyled">
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="users/{{ $post->user->id }}">{{ $post->user->name }}</a></p>
            </div>
            <div class="text-left d-inline-block w-75">
            <p class="post-content mb-2">{{ $post->text }}</p>
                <p class="text-muted mb-0">{{ $post->created_at }}</p>

                <span class="ml-2 d-inline-block">{{ $post->likedByUsers->count() }} いいね</span>
                @if (Auth::check()) <!-- ログインしている場合のみいいねボタンを表示 -->
                    @if (Auth::user()->likes->contains($post->id))
                        <form action="{{ route('posts.unlike', $post) }}" method="POST" class="d-inline-block ml-2 align-items-center">
                            @csrf
                            <button type="submit" class="btn btn-danger">いいねを取り消す<i class="fa fa-times"></i></button>
                        </form>
                    @else
                        <form action="{{ route('posts.like', $post) }}" method="POST" class="d-inline-block ml-2 align-items-center">
                            @csrf
                            <button type="submit" class="btn btn-success">いいね<i class=" fa fa-check pr-2000 d-inline"></i></button>
                        </form>
                    @endif
                @endif
            </div>

            @if ($post->user->id === Auth::id() )
                <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                    <form method="POST" action="{{ route('post.delete', $post->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">削除</button>
                    </form>
                    <a href="{{ route('post.edit', $post) }}" class="btn btn-primary">編集する</a>
                </div>
            @endif
        </li>
    </ul>
@endforeach
<div class="m-auto" style="width: fit-content"></div>
<div class="d-flex justify-content-center">{{ $posts->links('pagination::bootstrap-4') }}</div>

<style>
.post-content {
    font-size: 20px;
}
</style>

