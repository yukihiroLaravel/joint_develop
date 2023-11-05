<ul class="list-unstyled">
    @foreach($posts as $post)
        <li class="mb-3 text-center bgcolor">
            <div class="text-left d-inline-block w-75 mb-2">
                <div class="d-flex align-items-center justify-content-between">
                    <h2 class="mr-4 mt-3">{{ $post->post_title }}</h2>
                    <div>{{ $post->area }}</div>
                </div>
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 50) }}" alt="アバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $post->user_id) }}">{{ $post->user->name }}</a></p>
            </div>

            <div class="">
                <div class="text-left d-inline-block w-75">
                    <div class="row mt-2 justify-content-between">
                        <div class="col-4">
                            @if($post->imagepath !== null)
                            <img src="{{ asset($post->imagepath)}}" alt= "投稿画像"class="image-fit border img1">
                            @else
                            <img src="{{ asset('storage/image/noimage.png')}}" alt= "投稿画像" class="image-fit border img1">
                            @endif
                        </div>
                        <div class="col-7 border border-dark p-3">{{ $post->content }}</div>
                    </div>

                    <p class="text-muted">{{ $post->created_at }} </p>
                </div>
                @if (\Auth::id() === $post->user_id)
                  <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                     <form method="" action="">
                         <button type="submit" class="btn btn-danger">削除</button>
                     </form>
                     <a href="{{ route('users.edit', $post->user_id) }}" class="btn btn-primary">編集する</a>
                  </div>
                @endif  
            </div>
        </li>
    @endforeach    
</ul>