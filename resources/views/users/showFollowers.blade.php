@foreach ($followers as $follower)
<ul class="list-unstyled">
      <li class="mb-3 text-center">
          <div class="text-left d-inline-block w-75 mb-2">
              @if (isset($follower->profile_image) && $follower->profile_image)              
                  <img class="rounded-circle img-fluid" style="max-width: 70px; height: auto;" src="{{ asset('storage/images/' . $follower->profile_image) }}" alt="ユーザーのプロフィール画像">
              @else
                  <img class="mr-2 rounded-circle" src="{{ Gravatar::src($follower->email, 55) }}" alt="ユーザのアバター画像">
              @endif
              <p class="mt-3 mb-0 d-inline-block"><a  href="{{ route('users.show', $follower->id) }}">{{ $follower->name }}</a></p>
              @include('follows.follow_button',['user'=> $follower])
           </div>
      </li>
 </ul>
 @endforeach
 <div class="m-auto" style="width: fit-content">{{ $followers->links('pagination::bootstrap-4') }}</div>