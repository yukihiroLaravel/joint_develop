<ul class="list-unstyled">
    @foreach ($posts as $post)
        @php
            $user = $post->user;
        @endphp
            <li class="mb-3 text-center">
                <div class="text-left d-inline-block w-75 mb-2">
                    <img class="mr-2 rounded-circle" src="{{ Gravatar::src($user->email, 55) }}" alt="ユーザのアバター画像">
                    <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('users.show',$user->id) }}">{{ $user->name }}</a></p>
                </div>
                <div class="">
                    <div class="text-left d-inline-block w-75">
                        <p class="mb-2">{{ $post->text }}</p>
                        <p class="text-muted">{{ $post->created_at }}</p>
                    </div>
                    @if (Auth::id() === $post->user_id)
                        <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                            <form method="POST" action="{{ route('post.delete', $post->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">削除</button>            
                            </form>
                            <a href="#" class="btn btn-primary">編集する</a>
                        </div>
                    @endif
                </div>
            </li>
    @endforeach
</ul>

<div class="m-auto" style="width: fit-content">{{ $posts->links() }}</div>

<div class="d-flex justify-content-between">
    <a class="btn btn-danger text-light" data-toggle="modal" data-target="#deleteConfirmModal">退会する</a>
</div>

<div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>確認</h4>
            </div>
            <div class="modal-body">
                <label>本当に退会しますか？</label>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <form action="{{ route('users.delete', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">退会する</button>
                </form>
                <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
            </div>
        </div>
    </div>
</div>

