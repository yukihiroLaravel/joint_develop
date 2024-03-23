<ul class="list-unstyled">
    @foreach($followings as $following)
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-150 mb-2">
                {{$following->email}}
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($following->email, 55) }}" alt="ユーザのアバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="{{route('user.show',$following->id)}}">{{$following->name}}</a>
                    @auth
                        @if( Auth::user()->id == $user->id)
                            @include('follower.follower_button', ['user' => $following])</p>
                        @endif
                    @endauth
            </div>
            <div class="mb-3 text-center">
                <div class="text-center d-inline-block w-150">
                    <p class="mb-2">{{$following->followed_user_id}}</p>
                    <p class="text-muted">{{$following->created_at}}</p>
                </div>
            </div>
        </li>
    @endforeach
</ul>