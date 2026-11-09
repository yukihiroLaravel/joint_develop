@php
    $reactionCount = $comment->reactions->count();
@endphp
@auth
    <form method="POST" action="{{ route('comment.reaction.toggle', [$post->id, $comment->id]) }}"
        class="js-reaction-form d-inline">
        @csrf
        <button type="submit" class="btn reaction-btn p-0">
            <span
                class="du-reaction-emoji {{ $comment->isReactedBy(\Auth::id()) ? '' : 'is-inactive' }}">❤️</span>
            <span class="du-reaction-count">{{ $reactionCount > 0 ? $reactionCount : '' }}</span>
        </button>
    </form>
@else
    <a href="{{ route('login') }}" class="btn reaction-btn p-0">
        <span class="du-reaction-emoji is-inactive">❤️</span>
        <span class="du-reaction-count">{{ $reactionCount > 0 ? $reactionCount : '' }}</span>
    </a>
@endauth
