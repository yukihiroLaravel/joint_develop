<ul class="list-unstyled">
    @foreach ($posts as $post)
    @if (is_null($post->user->deleted_at))
    <li class="mb-3 text-center">
        
        <div class="text-left d-inline-block w-75 mb-2">
            <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
            <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $post->user->id) }}">{{ $post->user->name }}</a></p>
        </div>
        
        <div class="">
            <div class="text-left d-inline-block w-75">
                <p class="mb-2">{{ $post->text }}</p>
                <p class="text-muted">{{ $post->created_at }}</p>
            </div>
        </div>
    </li>
    @include('posts.edit_button')
    @endif
    @endforeach
</ul>
<div class="m-auto" style="width: fit-content">{{ $posts->links('pagination::bootstrap-4') }}</div>
