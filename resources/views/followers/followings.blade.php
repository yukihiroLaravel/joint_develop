@foreach($followings as $following)

<div class="mb-3">

    <img src="{{ Gravatar::src($following->email, 50) }}" class="rounded-circle">

    {{ $following->name }}

</div>

@endforeach

{{ $followings->links() }}