@foreach ($posts as $post)
    <ul class="list-unstyled">
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                @if($post->user->email)
                <img class="rounded-circle img-fluid" src="{{ Gravatar::src($post->user->email, 55) }}"
                    alt="{{ $post->user->name }}アバター画像">
                <p class="mt-3 mb-0 d-inline-block">
                    <a href="{{ route('user.show', $post->user->id) }}">{{$post->user->name}}</a>
                </p>
                @endif
            </div>
            <div class="">
                <div class="text-left d-inline-block w-75">
                    <p class="mb-2">{{ $post->text }}</p>
                    <p class="text-muted">{{ $post->updated_at }}</p>
                </div>
                @if ($post->user->id === Auth::id() )
                <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                    <form method="" action="">
                        <button type="submit" class="btn btn-danger">削除</button>
                    </form>
                    <a href="" class="btn btn-primary">編集する</a>
                </div>
                @endif
            </div>
        </li>
    </ul>
@endforeach
<div class="m-auto" style="width: fit-content">
    {{ $posts->links('pagination::bootstrap-4') }}
</div>