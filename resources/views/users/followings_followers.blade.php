<ul class="list-unstyled">
    @foreach ($relations as $relation)
    <li class="mb-3 text-center">
        <div class="text-left d-inline-block w-75 mb-2">
            @if($relation->profile_image)
                <img class="rounded-circle img-fluid" src="{{ asset('storage/uploads/' . $relation->id . '/' . $relation->profile_image) }}" alt="ユーザの画像" style="max-width: 100px; max-height: 100px;">
            @else
                <img class="rounded-circle img-fluid" src="{{ asset('storage/default-profile-image.png') }}" alt="デフォルトのプロフィール画像" style="max-width: 100px; max-height: 100px;">
            @endif            
            <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show',$relation->id) }}">{{$relation->name}}</a></p>
            @if (Auth::check() && Auth::id() !== $relation->id)
                @if (Auth::user()->isFollow($relation->id))
                    <form method="POST" action="{{ route('unFollow', $relation->id) }}" class="d-inline-block ml-4">
                        @csrf
                        @method('DELETE')
                        <div class="mt-3">
                            <button type="submit" class="btn btn-danger btn-block">フォローを外す</button>
                        </div>
                    </form>
                @else
                    <form method="POST" action="{{ route('follow', $relation->id) }}" class="d-inline-block ml-4">
                        @csrf
                        <div class="mt-3">
                            <button type="submit" class="btn btn-success btn-block">フォローする</button>
                        </div>
                    </form>
                @endif
            @endif
        </div>
    </li>
    @endforeach
</ul>
