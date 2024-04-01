<div class="container mt-3">
    @if (session('comment_register_message'))
        <div class="alert alert-success">
            {{ Session::get('comment_register_message') }}
        </div>
    @endif
    <h5 class="text-center">投稿内容</h5>
    <div class="text-center">
        <div class="text-left d-inline-block w-75 mb-2 border rounded">
            <div class="container">
                <div class="mb-2">
                    <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 30) }}" alt="ユーザのアバター画像">
                    <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $post->user->id) }}">{{ $post->user->name }}</a></p>
                </div>
                <p style="font-size: 20px;">{{ $post->text }}</p>
                <p class="text-muted">{{ $post->created_at }}</p>
            </div>
        </div>
    </div>
</div>