<h2 class="mt-5">あなたの投稿したコメント</h2>
<div class="movies row mt-5 text-center">
    @foreach ($comments as $comment)
        @php
            $comment = $user->comments->last();
        @endphp
        @if ($loop->iteration % 3 === 1 && $loop->iteration !== 1)
            </div>
            <div class="row text-center mt-3">
        @endif
            <div class="col-lg-4 mb-5">
                <div class="movie text-left d-inline-block">
                   
                    <div>
                        <dl>
                            <dt>コメント:</dt>
                            <dd>{{ $comment->id }}</dd>
                            <dt>content</dt>
                            <dd>{{ $comment->content }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
    @endforeach
</div>