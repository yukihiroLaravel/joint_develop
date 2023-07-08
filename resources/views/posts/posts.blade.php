@foreach ($posts as $post)
    <ul class="list-unstyled">
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                @if($post->user->email)
                    <img class="rounded-circle img-fluid" src="{{ Gravatar::src($post->user->email, 55) }}"
                        alt="{{ $post->user->name }}アバター画像">
                    <p class="mt-3 mb-0 d-inline-block">
                        <strong>
                            <a href="{{ route('user.show', $post->user->id) }}">{{$post->user->name}}</a>
                        </strong>
                    </p>
                @endif
            </div>
            <div class="">
                <div class="text-left d-inline-block w-75">
                    <strong>
                        <p class="mb-2">{!!nl2br(e($post->text))!!}</p>
                    </strong>
                    <p class="text-muted">{{ $post->updated_at }}</p>
                </div>
                @if ($post->user->id === Auth::id() )
                    <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                        <form method="POST" action="{{ route('post.delete', $post->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                        <a href="{{ route('post.edit', $post->id) }}" class="btn btn-success"><i class="fas fa-edit"></i>編集する</a>
                    </div>
                @endif
                @include('comments.comments')
            </div>
        </li>
    </ul>
@endforeach
<div class="m-auto" style="width: fit-content">
    {{ $posts->links('pagination::bootstrap-4') }}
</div>
