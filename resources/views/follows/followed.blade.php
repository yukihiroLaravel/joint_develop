@foreach ($followUsers as $followUser)
    <ul class="list-unstyled">
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
            <img class="mr-2 rounded-circle" src="{{ Gravatar::src($followUser->email, 55) }}" alt="ユーザのアバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show',$followUser->id) }}">{{ $followUser->name }}</a></p>
            </div>
        </li>
    </ul>
<div class="m-auto" style="width: fit-content"></div>
@endforeach
<ul class="pagination justify-content-center">{{ $followUsers->links('pagination::bootstrap-4') }}</ul>