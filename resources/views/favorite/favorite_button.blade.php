<div class="d-flex w-75 pb-4 m-auto">
    @php
        $totalFavorites = 0;
        $totalFavorites += $post->favoriteUsers->count();
    @endphp
    @if (Auth::check() && Auth::id() !== $post->user_id)
        @if (Auth::user()->isFavorite($post->id))
            <form method="POST" action="{{ route('unfavorite', $post->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit" style="border: none; background-color: white;">
                    <i class="fas fa-thumbs-up" style="color: #f7d55c; font-size: 30px;"></i>
                </button>
            </form>
        @else
            <form method="POST" action="{{ route('favorite', $post->id) }}">
                @csrf
                <button type="submit" style="border: none; background-color: white;">
                    <i class="far fa-thumbs-up" style="font-size: 30px;"></i>
                </button>
            </form>
        @endif
    @endif
    @if (Auth::check() && Auth::id() !== $post->user_id)
        <span class="ml-2 pb-1 badge badge-pill badge-success" data-toggle="modal" data-target="#favoriteUsersModal{{ $loop->iteration }}" style="font-size: 15px; text-align: center;">いいね数&nbsp;{{ $totalFavorites }}</span>
    @elseif (Auth::check() && Auth::id() === $post->user_id)
        <span class="pb-1 badge badge-pill badge-success" data-toggle="modal" data-target="#favoriteUsersModal{{ $loop->iteration }}" style="font-size: 15px; text-align: center;">いいね数&nbsp;{{ $totalFavorites }}</span>
    @endif
</div>

@if ($post->favoriteUsers->isNotEmpty())
    <div class="modal fade" id="favoriteUsersModal{{ $loop->iteration }}" tabindex="-1" role="dialog" aria-labelledby="favoriteUsersModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="favoriteUsersModalLabel">こちらの投稿をいいねしているユーザー</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="w-75 m-auto" style="padding-inline-start: 0;">
                        @foreach ($post->favoriteUsers as $user)
                            <li style="list-style: none;">
                                <div class="d-flex justify-content-between" style="margin-bottom: 10px;">
                                    <div style="font-size: 20px;">
                                        {{ $user->name }}
                                    </div>
                                    <div>
                                        <a href="{{ route('user.show', $user->id)}}" class="btn btn-primary">{{$user->name}}のプロフィール</a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">閉じる</button>
                </div>
            </div>
        </div>
    </div>
@endif




