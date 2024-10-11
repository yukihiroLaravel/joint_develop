<ul class="posts list-unstyled">
    @foreach($posts as $post)
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                <img class="rounded-circle img-fluid" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $post->user->id) }}">{{ $post->user->name }}</a></p>
            </div>
            <div class="post">
                <div class="text-left d-inline-block w-75">
                    <p class="mb-2">{!! nl2br($post->makeLink(e($post->content))) !!}</p>
                    <p class="text-muted">{{ $post->created_at }}</p>
                </div>
                    <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                        @if(Auth::id() === $post->user_id)
                            <form method="POST" action="{{ route('post.delete', $post->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">削除</button>
                            </form>
                            <a href="{{ route('post.edit', $post->id) }}" class="btn custom-btn-success">編集する</a>
                        @endif
                    </div>        
            </div>
        </li>
    @endforeach    
</ul>
@if (!empty($keyword))
<div class="m-auto" style="width: fit-content">{{ $posts->appends(['keyword' => request()->input('keyword')])->links('pagination::bootstrap-4') }}</div>
@else
<div class="m-auto" style="width: fit-content">{{ $posts->links('pagination::bootstrap-4') }}</div>   
@endif
