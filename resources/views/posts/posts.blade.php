@foreach ($posts as $post)
    @php
        $post = $user->posts->last();
    @endphp
        <ul class="list-unstyled">
            <li class="mb-3 text-center">
                <div class="text-left d-inline-block w-75 mb-2">
                    <img class="mr-2 rounded-circle" src="{{ Gravatar::src(email, 55) }}" alt="ユーザのアバター画像">
                    <p class="mt-3 mb-0 d-inline-block"><a href="#">{{ $user->name }}</a></p>
                </div>
                <div class="">
                    <div class="text-left d-inline-block w-75">
                        <p class="mb-2">{{ $post->text }}</p>
                        <p class="text-muted">{{ $post->create_at }}</p>
                    </div>
                    @if (Auth::id() === $post->user_id)
                        <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                            <form method="POST" action="{{ route('post.delete', $post->id) }}">
                                <button type="submit" class="btn btn-danger">削除</button>
                            </form>
                            <a href="{{ route('post.edit', $post->id) }}" class="btn btn-primary">編集する</a>
                        </div>
                </div>
            </li>
        </ul>
@endforeach
<div class="m-auto" style="width: fit-content"></div>