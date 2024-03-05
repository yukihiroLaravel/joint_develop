@if (isset($arraySearchWords))
    @php
        $searchedWords = implode('",' . "\n" . '"', $arraySearchWords);
    @endphp
    <h5 class="text-center mt-4 mb-4">
        @if ($posts->count() == 0)
            <span class="searched_words">"{{ $searchedWords }}"
            </span>が含まれる投稿はありませんでした。
        @else
            <span class="searched_words">"{{ $searchedWords }}"</span>を含む投稿の検索結果
        @endif
    </h5>
@endif
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
                </div>
                @if ($post->user_id == Auth::id())
                    <div class="d-flex justify-content-between pb-3 m-auto">
                        <form method="POST" action="{{ route('post.delete', $post->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                        <a href="" class="btn btn-primary">編集する</a>
                    </div>
                @endif
            </div>
        </li>
    @endforeach
</ul>
<div class="d-flex justify-content-center">
    @php
        $activeList = 'posts';
    @endphp
    @if (isset($searchWords))
        {{ $posts->appends(['activeList' => $activeList, 'searchWords' => $searchWords])->links('pagination::bootstrap-4') }}
    @else
        {{ $posts->appends(['activeList' => $activeList])->links('pagination::bootstrap-4') }}
    @endif
</div>
