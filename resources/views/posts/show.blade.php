<ul class="list-unstyled">
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                {{-- TODO 一旦、デザイン確認のため「thumbnailTemporaryAvatarImage.png」をダミー表示。「アバター」画像の仕様検討必要 --}}
                <img class="mr-2 rounded-circle" src="{{ asset('thumbnailTemporaryAvatarImage.png') }}" alt="ユーザのアバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="">{{ $user->name }}</a></p>
            </div>
            <div class="">
                <div class="text-left d-inline-block w-75">
                    <p class="mb-2"></p>
                    <p class="text-muted">{!! nl2br(e($post->text)) !!}</p>
                    <p class="text-muted">{{ $post->created_at }}</p>
                </div>
                @if (Auth::id() === $post->user_id)
                    <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                        <form method="" action="">
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                        <a href="" class="btn btn-primary">編集する</a>
                    </div>
                @endif
            </div>
        </li>
</ul>
<div class="m-auto" style="width: fit-content"></div>
