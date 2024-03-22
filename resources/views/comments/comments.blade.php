<div class="d-flex align-items-center flex-column">
    <div class="col-12 col-md-10 col-lg-8 mb-5 pt-3 pb-3" style="border: 1px solid silver; border-radius:5px;">
        <div class="d-flex align-items-center justify-content-centor mb-2">
            <img class="mr-2 rounded-circle" src="" alt="ユーザのアバター画像">
            <p class="mb-0"><a href="{{ route('user.show', Auth::id()) }}">{{ Auth::user()->name }}</a>
            </p>
        </div>
        <div>
            <div class="text-left d-inline-block col-12 mb-2">
                <p class="mb-2 post_content">コメント本文</p>
                <time class="text-muted">コメントのタイムスタンプ</time>
            </div>
            <div class="d-flex m-auto">
                <form method="POST" action="{{ route('post.delete', $post->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger mr-2">削除</button>
                </form>
                <a href="{{ route('post.edit', $post->id) }}" class="btn btn-primary">編集する</a>
            </div>
        </div>
    </div>
    <h5 class="text-center mb-3 pb-2 pr-4 pl-4" style="border-bottom: 4px solid #17a2b8">コメント一覧</h5>
    <ul class="col-12 list-unstyled d-flex align-items-center flex-column show_list_style">
        <li class="col-12 col-md-10 col-lg-8 pt-3 pb-3">
        </li>
    </ul>
    <div class="d-flex justify-content-center">
        {{ $usersList->links('pagination::bootstrap-4') }}
    </div>
</div>