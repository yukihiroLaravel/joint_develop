<div class="conteiner"><!-- コンテナを使って全要素をラップしてスタイルを整えた -->
<ul class="list-unstyled">
                    
        @foreach ($posts as $post)
            <li class="mb-3">
                <div class="row">
                    <div class="col-5 w-75">
                        <div class="text-left d-inline-block mb-2">
                             <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
                        </div>         
                             <p class="mt-3 mb-0 d-inline-block"><a href="#">{{ $post->user->name }}</a></p>
                    </div>
                    
                        <div class="col-7 text-right">
                             @include('follow.follow_button', ['post' => $post])
                        </div>
                </div>
                    <p>{{ $post->content }}</p>
                    <p>{{ $post->created_at }}</p> 
            </li>
        @endforeach
        
        <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                @if (Auth::id() === $post->user_id)
                <form method="POST" action="{{ route('post.delete', $post->id) }}">
                @csrf
                @method('DELETE')
                        <button type="submit" class="btn btn-danger">削除</button>
                </form>
                <a href="" class="btn btn-primary">編集する</a>
        </div>
                @endif
</ul>

<div class="m-auto" style="width: fit-content">
{{ $posts->links('pagination::bootstrap-4') }}
</div>