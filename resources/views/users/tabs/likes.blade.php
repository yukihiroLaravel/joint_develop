@forelse($likes as $post)
    <div class="border p-2 mb-3">

        <a href="{{ route('user.show', $post->user->id) }}">
            {{ $post->user->name }}
        </a>

        <p class="mb-1">{{ $post->content }}</p>

        @if($post->image)
            <img src="{{ asset('storage/' . $post->image) }}"
                 class="img-fluid mb-2">
        @endif

        @include('like.like_button', ['post' => $post])
    </div>
@empty
    <p>いいねした投稿はありません。</p>
@endforelse

{{ $likes->links() }}
