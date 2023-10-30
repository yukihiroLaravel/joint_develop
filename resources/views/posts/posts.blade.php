<ul class="list-unstyled">
        <li class="mb-3 text-center">
            @foreach ($posts as $post)
                <div class="text-left d-inline-block w-75 mb-2">
                    <img class="mr-2 rounded-circle" src="{{ Gravatar::src( $post->user->email , 55) }}" alt="ユーザのアバター画像">
                    <p class="mt-3 mb-0 d-inline-block"><a href="">{{ $post->user->name }}</a></p>
                    </div>
                    <div class="">
                        <div class="text-left d-inline-block w-75">
                            <p class="mb-2">{{ $post->content }}</p>
                            <p class="text-muted">{{ $post->created_at }}</p>
                        </div>
                    </div>
                @if (\Auth::id() === $post->user_id)
                  <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                     <form method="POST" action="">
                         <button type="submit" class="btn btn-danger">削除</button>
                     </form>
                     <a href="{{ route('users.edit', $post->user_id) }}" class="btn btn-primary">編集する</a>
                  </div>
                @endif  
             @endforeach
            </div>
        </li> 
</ul>
<div class="m-auto" style="width: fit-content">{{ $posts->links('pagination::bootstrap-4') }}</div>