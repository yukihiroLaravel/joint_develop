@foreach($posts ?? '' as $post)
<ul class="list-unstyled">
    <li class="mb-3 text-center">
        <div class="text-left d-inline-block w-75 mb-2">
            <img src="{{ Gravatar::src($post->user->email, 55)}}" alt="ユーザのアバター画像" class="mr-2 rounded-circle">
            <p class="mt-3 mb-0 d-inline-block"><a href="">{{$post->user->nickname}}</a></p>
        </div>
        <div class="">
            <div class="text-left d-inline-block w-75">
                <p class="mb-2">{!! nl2br(e($post->content)) !!}</p>
                <p class="text-muted">{{$post->created_at->format('Y-m-d H:i:s')}}</p>
            </div>

            @if(Auth::check() && Auth::user()->id === $post->user_id)
            <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                <form method="" action="">
                    <button type="submit" class="btn btn-danger">削除</button>
                </form>
                <a href="{{route('post.edit', $post->id)}}" class="btn btn-primary">編集する</a>
            </div>
            @endif

        </div>
    </li>
</ul>
<div class="m-auto" style="width: fit-content"></div>
@endforeach

<div class="pagination justify-content-center">
    {{ $posts ?? ''->links('pagination::bootstrap-4') }}
</div>