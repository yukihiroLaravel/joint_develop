<ul class="list-unstyled">
    @foreach ($follows as $follow)
        @foreach ($follow->posts as $post)
            <li class="mb-3 text-center">
                <div class="text-left d-inline-block w-75 mb-2">
                    <img class="mr-2 rounded-circle" src="{{ Gravatar::src($follow->email, 55) }}" alt="ユーザのアバター画像">
                    <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $follow->id) }}">{{ $follow->name }}</a></p>
                </div>
                <div class="text-left d-inline-block w-75">
                    <p class="mb-2">{{ $post->text }}</p>
                    @if (isset($post->image))
                        <p class="mb-2"><img src="{{ asset($post->image) }}" width="70%" height="70%"></p>
                    @endif
                    <p class="text-muted">{{ $post->created_at }}</p>
                </div>
            </li>
        @endforeach
    @endforeach
</ul>