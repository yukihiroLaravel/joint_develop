<div style="margin-left: 140px;">
    @foreach ($posts as $post)
        <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">                
        <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('signup.post', $post->user->id) }}"> {{$post->user->name}}</a></p>
        <div class="">
            <div class="text-left d-inline-block w-75">
                <p class="mt-3 mb-0">{{$post->content}}</p>
                <p class="text-muted">{{$post->created_at}}</p>
            </div>
        </div>
    @endforeach
</div>
<div class="m-auto" style="width: fit-content">
    {{ $posts->links('pagination::bootstrap-4') }}
</div>