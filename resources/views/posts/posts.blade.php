@php
    $activeList = 'posts';
@endphp
@includeWhen(isset($arraySearchWords), 'commons.search_result_text', [
    'subjects' => $posts,
    'subjectsName' => '投稿',
])
<ul class="list-unstyled d-flex align-items-center flex-column show_list_style">
    @foreach ($posts as $post)
        <li class="col-11 col-sm-10 col-lg-8 pt-3 pb-3">
            <div class="d-flex align-items-center justify-content-centor mb-2">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
                <p><a href="{{ route('user.show', $post->user_id) }}">{{ $post->user->name }}</a>
                    @include('follows.follow_button', ['id' => $post->user_id])</p>
            </div>
            <div>
                <div class="text-left d-inline-block col-12 mb-2">
                    <p class="mb-2 post_content">{!! nl2br(e($post->content)) !!}</p>
                    <time class="text-muted">{{ $post->created_at }}</time>
                </div>
                <div class="pt-2 col-12 action_area">
                    {{-- いいね・コメントのボタンが入ります --}}
                    @if ($post->user_id == Auth::id())
                        <div class="d-flex m-auto">
                            <form method="POST" action="{{ route('post.delete', $post->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mr-2">削除</button>
                            </form>
                            <a href="{{ route('post.edit',$post->id) }}" class="btn btn-primary">編集する</a>
                        </div>
                    @endif
                </div>
            </div>
        </li>
    @endforeach
</ul>

@include('commons.index_pagination', ['subjects' => $posts])
