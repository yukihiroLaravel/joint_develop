@if (!empty($keyword))
    <div class="w-75 m-auto">
        <p>「{{ $keyword }}」の検索結果：{{ $posts->total() }}件</p>
    </div>    
@endif
@if ($posts->isEmpty())    
    <p class="text-center mt-4">検索結果はありませんでした。</p>
@else
<ul class="list-unstyled">
    @foreach ($posts as $post)
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="">{{$post->user->name}}</a></p>
                @include('users.follow_button',['user'=> $post->user])
            </div>
            <div class="contaier">
                <div class="text-left d-inline-block w-75">
                    <p class="mb-2">{{$post->content}}</p>
                    @if ($post->images->isNotEmpty())
                        <div class="mb-2">
                            @foreach ($post->images as $image)
                                <img src="{{ asset('storage/' . $image->file_path) }}" alt="{{ $image->file_name }}" style="max-width: 200px; margin-right: 10px; margin-bottom: 5px;">
                            @endforeach
                        </div>
                    @endif
                    <p class="text-muted">{{$post->created_at}}</p>
                </div>
                @if (Auth::id() === $post->user_id)
                    <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                        <form method="POST" action="{{ route('posts.delete', $post->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">編集する</a>
                    </div>
                @endif
            </div>
        </li>
    @endforeach
</ul>
<div class="m-auto" style="width: fit-content">{{ $posts->appends(request()->query())->links('pagination::bootstrap-4') }}</div>
@endif