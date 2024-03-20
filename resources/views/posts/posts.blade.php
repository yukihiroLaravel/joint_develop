<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<body>
@if (session('successMessage'))
 <div class="alert alert-success text-center">{{ session('successMessage') }}</div>
@endif

<ul class="list-unstyled">
    @foreach ($posts as $post)
        @php
            $user = $post->user;
        @endphp
            <li class="mb-3 text-center">
                <div class="text-left d-inline-block w-75 mb-2">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($user->email, 55) }}" alt="ユーザのアバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $user->id) }}">{{ $user->name }}</a></p>
            </div>
            <div class="container">
                <div class="text-left d-inline-block w-75">
                    <p class="mb-2">{{ $post->text}}</p>
                    @if ($post->img_path)
                    <img src="{{ asset('storage/images/' . $post->img_path) }}" alt="投稿画像" class="post-image" onclick="showModal(this.src)">
                    @endif
                    <p class="text-muted">{{ $post->created_at }}</p>
                </div>
                @if (Auth::check() && Auth::id() === $post->user_id)
                    <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                        <form action="{{ route('post.delete', $post->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                        <a href="{{ route('post.edit', $post->id) }}" class="btn btn-primary">編集する</a>
                    </div>
                @endif
            </div>
        </li>
    @endforeach
</ul>
<div class="m-auto" style="width: fit-content">{{ $posts->links() }}</div>

<div id="imageModal" class="modal">
    <span id="closeModal" class="close">&times;</span>
    <img class="modal-content" id="modalImage">
</div>

<script>
function showModal(src) {
    // モーダルウィンドウに画像を設定して表示
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModal').style.display = 'block';
}

// モーダルの閉じるボタンでモーダルを閉じる
document.getElementById('closeModal').addEventListener('click', function() {
    document.getElementById('imageModal').style.display = 'none';
});

// モーダルの外側をクリックしてもモーダルを閉じる
window.onclick = function(event) {
    if (event.target == document.getElementById('imageModal')) {
        document.getElementById('imageModal').style.display = 'none';
    }
}
</script>
</body>