@if (session('successMessage'))
 <div class="alert alert-success text-center">{{ session('successMessage') }}</div>
@endif

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
            <div class="container">
                <div class="text-left d-inline-block w-75">
                    <p class="mb-2">{{ $post->text}}</p>
                    <p class="text-muted">{{ $post->created_at }}</p>
                </div>
                <a href="{{ route('comments.show', $post->id) }}" class="btn btn-primary">コメントする</a> 
                @if (Auth::check() && Auth::id() === $post->user_id)
                    <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                        <form action="{{ route('post.delete', $post->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                        <a href="{{ route('post.edit', $post->id) }}" class="btn btn-primary">編集する</a>
                    </div>
                @endif
                <div class="col-lg-4 mb-5">
                <div class="post text-left d-inline-block">
                    @php
                        $countFavoriteUsers = $post->favoriteUsers()->count();
                    @endphp
                    <div class="text-right mb-2">いいね！
                        <span class="badge badge-pill badge-success">{{ $countFavoriteUsers }}</span>
                    </div>
                </div>
                @include('favorite.favorite_button', ['post' => $post])
            </div>
        </li>
    @endforeach
</ul>
<div class="m-auto" style="width: fit-content">{{ $posts->links() }}</div>