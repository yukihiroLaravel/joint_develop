@if (Auth::check() && Auth::id() !== $followuser->id)
    @if (Auth::user()->isfollow($followuser->id))
        <form method="POST" action="{{ route('unfollow', $followuser->id) }}">
            @csrf
            @method('DELETE')
            <div align="center">
                <button type="submit" style="width:70%;padding:10px;font-size:20px;" class="btn btn-danger btn btn-primary">フォロ―を外す</button>
            </div>
        </form>
    @else
        <form method="POST" action="{{ route('follow', $followuser->id) }}">
            @csrf
            <div align="center">
                <button type="submit" style="width:70%;padding:10px;font-size:20px;" class="btn btn-success">フォロ―する</button>
            </div>
        </form>
    @endif
@endif