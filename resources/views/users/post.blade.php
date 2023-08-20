<div class="users row mt-5 text-center">
    @foreach ($posts as $posts)
        @if ($loop->iteration % 3 === 1 && $loop->iteration !== 1)
            </div>
            <div class="row text-center mt-3">
        @endif
            <div class="col-lg-4 mb-5">
                <div class="post text-left d-inline-block">
                    <div>
                        @if ($user)
                            <iframe src="{{ $user->user_id }}?controls=1&loop=1&playlist={{ $user->user_id }}" frameborder="0"></iframe>
                        @else
                            <iframe></iframe>
                        @endif
                    </div>
                    <p>
                        @if (isset($post->title))
                            {{ $post->title }}
                        @endif
                    </p>
                    <p>
                        @if (isset($user->comment))
                            {{ $user->comment }}
                        @endif
                    </p>
                    @if (Auth::id() === $user->user_id)
                        <form method="POST" action="{{ route('user.delete', $user->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">この投稿を削除する</button>
                        </form>
                    @endif
                </div>
            </div>
    @endforeach
</div>
{{ $users->links('pagination::bootstrap-4') }}