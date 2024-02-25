<ul class="list-unstyled">
@foreach($posts as $post)
    <li class="mb-3 text-center">
        <div class="text-left d-inline-block w-75 mb-2">
            <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
            <p class="mt-3 mb-0 d-inline-block"><a href="">{{ $post->user->name }}</a></p>
        </div>
        <div class="">
            <div class="text-left d-inline-block w-75">
                <!-- $post が使われている部分 -->
                <p class="mb-2">{{ $post->content }}</p>
                <p class="text-muted">{{ $post->created_at }}</p>
            </div>
            <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                <!-- 本人の場合、削除と編集するボタンを表示 -->
                @if(Auth::check() && Auth::user()->id == $post->user->id)
                    <form method="POST" action="{{ route('users.update', ['id' => Auth::id()]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">削除</button>
                    </form>
                    <a href="" class="btn btn-primary">編集する</a>
                @else
                    @include('follow.follow', ['userId' => $post->user->id])
                @endif
            </div>
        </div>
    </li>
@endforeach
</ul>
<div class="m-auto" style="width: fit-content">{{ $posts->links('pagination::bootstrap-4') }}</div>
