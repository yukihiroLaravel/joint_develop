<div class="text-center d-inline-block w-75">
    @php
        $movie = $user->movies->last();
    @endphp
    <div>
        @if ($movie)
            <iframe width="290" height="163.125" src="{{ 'https://www.youtube.com/embed/'.$movie->youtube_id }}?controls=1&loop=1&playlist={{ $movie->youtube_id }}" frameborder="0"></iframe>
        @else
            <iframe width="290" height="163.125" src="https://www.youtube.com/embed/" frameborder="0"></iframe>
        @endif
    </div>
    <p>
        @if (isset($movie->title))
            {{ $movie->title }}
        @endif
        
    </p>
    @if (Auth::id() !=== $movie->user_id)
        <form method="POST" action="{{ route('movie.delete', $movie->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger"><i class="fas fa-trash-alt"></i>動画削除</button>
        </form>
    @php 
     dump($movie)
    @endphp 
    @endif
</div>        
            