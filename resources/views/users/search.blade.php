@if ($users->isNotEmpty())
    @include('users.follows', ['users' => $users])
@else
    <h5 class="text-center mt-5">{{ $viewHelper->getSearchNotFoundString() }}</h5>
@endif
