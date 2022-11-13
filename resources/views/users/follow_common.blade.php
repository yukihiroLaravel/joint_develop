@foreach ($users as $user)
    <div class="text-left d-inline-block w-100 mb-2 card-header" data-aos="flip-down">
        <img class="mr-2 rounded-circle" src="{{ Gravatar::src($user->email, 55) }}" alt="ユーザのアバター画像">
        <p class="mt-3 mb-0 d-inline-block post-line"><a href="{{ route('user.show', $user) }}">{{ $user->name }}</a></p>
    </div>
@endforeach