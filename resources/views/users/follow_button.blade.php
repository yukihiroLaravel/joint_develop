@if (Auth::check() && Auth::id() !== $followUser->id)
    @if (Auth::user()->isFollow($followUser->id))
        <form method="POST" action="{{ route('unFollow', $followUser->id) }}">
            @csrf
            @method('DELETE')
            <div align="center">
                <button type="submit" style="width:70%;padding:10px;font-size:20px;" class="btn btn-danger btn btn-primary">フォロ―を外す</button>
            </div>
        </form>
    @else
        <form method="POST" action="{{ route('follow', $followUser->id) }}">
            @csrf
            <div align="center">
                <button type="submit" style="width:70%;padding:10px;font-size:20px;" class="btn btn-success">フォロ―する</button>
            </div>
        </form>
    @endif
@endif