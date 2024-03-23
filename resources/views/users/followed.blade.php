<ul class="list-unstyled">
    @php
        // var_dump($followers);
    @endphp
    @foreach($followers as $follower)
    @php
        // dd($follower->email);
        // var_dump($follower);
    @endphp
        <li class="mb-3 text-right">
            <div class="text-left d-inline-block w-150 mb-2">
                {{$follower->email}}
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($follower->email, 55) }}" alt="ユーザのアバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="{{route('user.show',$follower->id)}}">{{$follower->name}}</a></p>
            </div>
            <div class="mb-3 text-right">
                <div class="text-right d-inline-block w-150">
                    <p class="mb-2">{{$follower->followed_user_id}}</p>
                    <p class="text-muted">{{$follower->created_at}}</p>
                </div>
            </div>
        </li>
    @endforeach
</ul>
{{-- <div class="m-auto" style="width: fit-content">{{ $posts->links('pagination::bootstrap-4') }}</div> --}}