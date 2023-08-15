<h2 class="mt-5 mb-5">チャンネル一覧</h2>
<div class="movies row mt-5 text-center">
    @foreach ($users as $user)
    @php
            $movies = $user->movies()->get();
            $totalFavorites = 0;
            foreach ($movies as $movie){
                $totalFavorites += $movie->favoriteUsers()->count();
            }
            $movie = $user->movies->last();
            $videoTitle="※動画が未登録です";
            if ($movie) {
                $keyName = config('app.YouTubeDataApiKey');
                $apiUrl = "https://www.googleapis.com/youtube/v3/videos?id={$movie->youtube_id}&key={$keyName}&part=snippet";
                $jsonData = file_get_contents($apiUrl);
                if ($jsonData) {
                    $decodedData = json_decode($jsonData, true);
                    if ($decodedData['pageInfo']['totalResults'] !== 0){
                        $videoTitle = $decodedData['items']['0']['snippet']['title'];
                    }
                } else {
                    $videoTitle="※一時的な情報制限中です";
                }
            }
        @endphp
        @if ($loop->iteration % 3 === 1 && $loop->iteration !== 1)
            </div>
            <div class="row text-center mt-3">
        @endif
            <div class="col-lg-4 mb-5">
                <div class="movie text-left d-inline-block">
                    <div class="text-right">
                        <span class="badge badge-pill badge-success">{{ $totalFavorites }} いいね!</span>
                    </div>
                    <a href="{{ route('user.show', $user->id) }}">＠{{ $user->name }}</a>
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
                        @else
                            {{ $videoTitle }}
                        @endif
                    </p>
                </div>
            </div>
    @endforeach
</div>
{{ $users->links('pagination::bootstrap-4') }}