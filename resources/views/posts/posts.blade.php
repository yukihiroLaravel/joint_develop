<ul class="list-unstyled">
    @foreach ($posts as $post)
        @php
            $user = $post->user;
        @endphp
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($user->email, 55) }}" alt="ユーザのアバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $user->id) }}">{{ $user->name }}</a></p>
            </div>

            <div class="new-line">
                <div class="text-left d-inline-block w-75">
                    <h5 class="mb-3">{{ $post->text }}</h5>
                    <p class="text-muted">{{ $post->created_at }}</p>
                    @php
                        $countFavoriteUsers = $post->favoriteUsers()->count();
                    @endphp
                    <div class="btn-group" role="group">
                        <span class="badge badge-pill badge-secondary">{{ $countFavoriteUsers }} いいね!</span>
                    </div>
                    <div class="btn-group">
                        @include('favorite.favorite_button', ['post' => $post])
                    </div>
                </div>
                @if (Auth::id() === $post->user_id)
                    <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                        <form method="POST" action="{{ route('post.delete', $post->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                        <a href="{{ route('post.edit',$post->id) }}" class="btn btn-primary">編集する</a>
                    </div>
                @endif
            </div>
        </li>
    @endforeach
</ul>
<div class="m-auto" style="width: fit-content">{{ $posts->links() }}</div>