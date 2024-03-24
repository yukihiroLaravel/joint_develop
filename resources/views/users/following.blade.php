<ul class="list-unstyled">
    @foreach($followings as $following)
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-150 mb-2">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($following->email, 55) }}" alt="ユーザのアバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="{{route('user.show',$following->id)}}">{{$following->name}}</a></p>
                    @auth
                        @if( Auth::user()->id == $user->id)
                            <p>@include('follower.follower_button', ['user' => $following])</p>
                        @endif
                    @endauth
            </div>
        </li>
    @endforeach
</ul>