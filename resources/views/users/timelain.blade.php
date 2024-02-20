<li class=" mt-5 text-center">
    @foreach ($posts as $post)
        @php
            $post = $user->posts->all();
        @endphp
            <div class="col-lg-4 mb-5">
                <div class="movie text-left d-inline-block">
                    ＠{{ $user->name }}
                    <div>
                        @if ($movie)
                            <iframe width="290" height="163.125" src="{{ 'https://www.youtube.com/embed/'.$movie->youtube_id }}?controls=1&loop=1&playlist={{ $movie->youtube_id }}" frameborder="0"></iframe>
                        @else
                            <iframe width="290" height="163.125" src="https://www.youtube.com/embed/" frameborder="0"></iframe>
                        @endif
                    </div>

                </div>
            </div>
    @endforeach
</div>
{{ $users->links('pagination::bootstrap-4') }}