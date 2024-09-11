<ul class="list-unstyled">
    @foreach ($posts as $post)
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $post->user->id) }}">{{ $post->user->name }}</a></p>
            </div>
            <div class="">
                <div class="text-left d-inline-block w-75">
                    <p class="mb-2">{{ $post->post }}</p>
                    @if ($post->image_path)
                        @php
                            // ファイルの拡張子を取得
                            $extension = pathinfo($post->image_path, PATHINFO_EXTENSION);
                        @endphp
                        @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                            <!-- 画像の場合 -->
                            <img src="{{ asset('storage/' . $post->image_path) }}" alt="投稿画像" class="img-fluid">
                        @elseif (in_array($extension, ['mp4']))
                            <!-- 動画の場合 -->
                            <video controls width="1000" playsinline class="img-fluid">
                                <source src="{{ asset('storage/' . $post->image_path) }}" type="video/{{ $extension }}">
                                    <p>動画を使用できるブラウザで閲覧して下さい。</p>
                            </video>
                        @endif
                    @endif
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
    @endforeach
</ul>
<div class="m-auto" style="width: fit-content">
    {{ $posts->links('pagination::bootstrap-4') }}
</div>