@foreach($followers as $follower)

<div class="mb-3">

    <img src="{{ Gravatar::src($follower->email, 50) }}"class="rounded-circle">

    {{ $follower->name }}

</div>

@endforeach

{{ $followers->links() }}