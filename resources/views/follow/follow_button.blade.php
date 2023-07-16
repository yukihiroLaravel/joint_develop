<!DOCUMENT html>
<html lang="ja">
    <head>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </head>
    <body>
        @if (Auth::check() && Auth::id() !== $user->id)
            <div class="d-inline-flex text-end">
                @if (Auth::user()->isFollow($user->id))
                    <form method="POST" action="{{route('unfollow', $user->id)}}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-user-minus"></i> フォロー解除
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{route('follow', $user->id)}}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-user-plus"></i> フォロー
                        </button>
                    </form>
                @endif
            </div>
    @endif
    </body>
</html>
