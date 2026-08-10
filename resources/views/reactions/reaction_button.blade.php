<form method="POST" action="{{ route('reaction.toggle', $post->id) }}" class="js-reaction-form d-inline">
    @csrf
    <button type="submit" class="btn reaction-btn p-0">
        <span class="du-reaction-emoji {{ $post->isReactedBy(\Auth::id()) ? '' : 'is-inactive' }}">❤️</span>
        @php
        $reactionCount = $post->reactions->count();
        @endphp
        <span class="du-reaction-count">{{ $reactionCount > 0 ? $reactionCount : '' }}</span>
    </button>
</form>
