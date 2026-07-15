<form method="POST" action="{{ route('reaction.toggle', $post->id) }}" class="d-inline">
    @csrf
    <button type="submit" class="btn p-0">
        <span class="reaction-emoji {{ $post->isReactedBy(\Auth::id()) ? '' : 'is-inactive' }}">❤️</span>
        @php
        $reactionCount = $post->reactions->count();
        @endphp
        <span class="reaction-count">{{ $reactionCount > 0 ? $reactionCount : '' }}</span>
    </button>
</form>