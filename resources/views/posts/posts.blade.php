@if (isset($arraySearchWords))
    @php
        $searchedWords = implode('",' . "\n" . '"', $arraySearchWords);
    @endphp
    <h5 class="text-center mt-4 mb-4"><span class="searched_words">
            @if ($posts->count() == 0)
                "{{ $searchedWords }}"
        </span>が含まれる投稿はありませんでした。
    @else
        "{{ $searchedWords }}"</span>の検索結果</h5>
@endif
</h5>
@endif
<ul class="list-unstyled">
    @foreach ($posts as $post)
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="">{{ $post->user->name }}</a></p>
            </div>
            @if ($post->user->id == Auth::id())
                <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                    <form method="POST" action="{{ route('post.delete', $post->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">削除</button>
                    </form>
                    <a href="" class="btn btn-primary">編集する</a>
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
