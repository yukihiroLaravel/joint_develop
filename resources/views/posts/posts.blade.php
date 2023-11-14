@foreach ($posts as $post)
<ul class="list-unstyled">
    <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                   <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
                 <p class="mt-3 mb-0 d-inline-block"><a  href="{{ route('users.show',$post->user_id) }}">{{ $post->user->name }}</a></p>
                   @if(isset($searchResults))  <!-- 検索結果表示 -->
                    <p class="mb-2 text-break">{!! preg_replace(
                        '/[' . preg_quote($searchQuery, '/') . ']/iu', 
                        '<span style="background-color: yellow;">$0</span>', $post->content) !!}</p>
                @else   <!-- 投稿一覧表示 -->
                    <p class="mb-2 text-break">{!! nl2br(e($post->content)) !!}</p>
                @endif
                <!-- リプライが１つ以上の場合、リプライ一覧表示へのリンクを表示 -->
                @if ($post->replies->count() > 0)
                    <a href="{{ route('replies.index', $post->id) }}">リプライ{{ $post->replies->count() }}件をすべて見る</a>
                @endif
                <p class="text-muted">{{ $post->created_at }}</p>
            </div>
                <!-- 各アイコン -->
            <div class="d-flex justify-content-between w-50 pb-3 m-auto">
                    <!-- 「イイねがついてる場合」 -->
                <a href="{{ route('favorite',$post->id) }}">
                    @if(isset($isfavorite) && $isfavorite !== false) 
                       <i class="fa fa-thumbs-up fa-2x" style="color: blue;"></i>
                    @else
                     <!-- イイねがついていない場合　-->
                       <i class="fa fa-thumbs-up fa-2x" style="color: black;"></i>
                    @endif                    
                </a>
                <!-- 「リプライ」 -->
                <a href="{{ route('replies.create',$post) }}">
                    <i class="fa fa-comment fa-2x" style="color: black; "></i>
                </a>
                @if(Auth::check() && Auth::id() == $post->user_id)
                    <!-- 投稿編集 -->
                    <a href="{{ route('post.edit',$post->id) }}" >
                        <i class="fa fa-edit fa-2x" style="color: black; "></i>
                    </a>
                    <!-- 投稿削除 -->
                    <form id="delete-form">
                        <i class="fa fa-trash fa-2x" style="color: red; cursor: pointer;" data-toggle="modal" data-target="#postDeleteConfirmModal"></i>
                    </form>
                    <div class="modal fade" id="postDeleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4>確認</h4>
                                </div>
                                <div class="modal-body">
                                    <label>本当に削除しますか？</label>
                                </div>
                                <div class="modal-footer d-flex justify-content-between">
                                    <form method="POST" action="{{ route('post.delete', $post->id) }}"> 
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">削除する</button>
                                    </form>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </li>
    </ul>
@endforeach
@if(isset($searchResults))
    <div class="m-auto" style="width: fit-content">{{ $searchResults->appends(request()->query())->links('pagination::bootstrap-4') }}</div>
@else
    <div class="m-auto" style="width: fit-content">{{ $posts->links('pagination::bootstrap-4') }}</div>
@endif