<form method="POST" action="{{ route('reaction.toggle', $post->id) }}" class="d-inline">
    @csrf
    <button type="submit" class="btn p-0">
        <span class="reaction-emoji {{ $post->isReactedBy(\Auth::id()) ? '' : 'is-inactive' }}">❤️</span>
        <span class="reaction-count">{{ $post->reactions->count() > 0 ? $post->reactions->count() : '' }}</span>
    </button>
</form>