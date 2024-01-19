<ul class="list-unstyled">
    @foreach ($posts as $post)
        <li class="mb-3 text-center pr-5 pl-5">
        <div class="row text-center">
            <div class="col-6 text-left d-inline-block mb-2">
                <p class="mt-3 mb-0 d-inline-block">
                    <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
                    <a href="{{ route('user.show', $post->user->id) }}">{{$post->user->name}}</a>
                </p>
            </div>
            @php
                $countFavoriteUsers = $post->favoriteUsers()->count();
            @endphp
            <div class="col-6 text-right mt-4">いいね！
                <span class="badge badge-pill badge-success">{{ $countFavoriteUsers }}</span>
                <div class="d-inline-block">
                    @include('favorite.favorite_button',['post'=>$post])
                </div>
            </div>
        </div>


            <div class="">
                <div class="text-left d-inline-block w-75">
                    <p class="mb-2">{{$post->content}}</p>
                        <div class="text-left mb-3">
                            @if(isset($post->img_path))
                            <img src="{{ Storage::url($post->img_path) }}" width="25%">
                            @endif
                        </div>
                    <p class="text-muted">{{$post->created_at}}</p>
                </div>
                @if (Auth::id() === $post->user_id)
                <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                    <form method="POST" action="{{ route('posts.delete', $post->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">削除</button>
                    </form>
                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">編集する</a>
                </div>
                @endif
            </div>
        </li>
    @endforeach
</ul>
<div class="m-auto" style="width: fit-content">
    {{ $posts->appends(request()->query())->links('pagination::bootstrap-4') }}
</div>
