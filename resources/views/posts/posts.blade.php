<ul class="list-unstyled">
    @foreach($posts as $post)
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 50) }}" alt="">
                <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $post->user_id) }}">{{ $post->user->name }}</a></p>
            </div>

            <div class="">
                <div class="text-left d-inline-block w-75">
                    <p class="mb-2">{{ $post->content }}</p>
                    <p class="text-muted">{{ $post->created_at }} </p>
                </div>
                @if (\Auth::id() === $post->user_id)
                  <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                     <form method="" action="">
                         <button type="submit" class="btn btn-danger">削除</button>
                     </form>
                     <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">編集する</a>
                  </div>
                @endif  
            </div>
        </li>
    @endforeach    
</ul>