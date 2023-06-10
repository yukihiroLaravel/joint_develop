@foreach ($followedUsers as $followedUser )
    <ul class="list-unstyled">
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($followedUser->email, 55) }}" alt="{{ $followedUser->email }}のアバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $followedUser->id) }}">{{ $followedUser->name }}</a></p>
            </div>
            <div class="text-left d-inline-block w-75">
                <p class="mb-1">{{ $followedUser->posts()->latest()->first()->text }}</p>
                <p class="text-muted">{{ $followedUser->posts()->latest()->first()->updated_at }}</p>
            </div>         
        </li>
    </ul>
@endforeach
<div class="m-auto" style="width: fit-content"></div>
{{ $followedUsers->links('pagination::bootstrap-4') }}
