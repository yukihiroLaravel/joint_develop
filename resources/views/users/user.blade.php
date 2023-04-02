@include('favorite.favorite_button', ['movie' => $movie])
                    @if (Auth::id() === $movie->user_id)
                        <div class="d-flex justify-content-between">
                            <form method="POST" action="{{ route('movie.delete', $movie->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">この動画を削除する</button>
                            </form>
                            <a href="{{ route('movie.edit', $movie->id) }}" class="btn btn-primary">編集する</a>
                        </div>
                    @endif