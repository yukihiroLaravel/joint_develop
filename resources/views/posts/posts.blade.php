
<ul class="list-unstyled">
    <li class="mb-3 text-center">
            @foreach ($posts as $post)
                <div class="text-left d-inline-block w-75 mb-2">
                    <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
                        <p class="mt-3 mb-0 d-inline-block"><a href="https://laravel-fly3.fly.dev/users/76">{{$post->user->name}}</a></p>
                </div>
                <div class="text-left d-inline-block w-75">
                    <p class="mb-2">{{$post->content}}</p>
                    <p class="text-muted">{{$post->updated_at}}</p>
                </div>
            @endforeach
                </li>
</ul>
<div class="m-auto" style="width: fit-content">
    {{ $posts->links('pagination::bootstrap-4') }}
</div>
