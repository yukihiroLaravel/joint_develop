@foreach ($posts as $post)
    <li class="mb-3 text-center">
        <div class="text-left d-inline-block w-75 mb-2">
            <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
            <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $post->user->id) }}">{{ $post->user->name }}</a></p>
        </div>
        <div class="new-line">
            <div class="text-left d-inline-block w-75">
                <p class="mb-2">{!! nl2br(e($post->content)) !!}</p>
                <p class="text-muted">{{ $post->created_at }}</p>
                @include('follow.follow_button',['user'=>$post->user])
            </div>      
        </div>
    </li>
@endforeach