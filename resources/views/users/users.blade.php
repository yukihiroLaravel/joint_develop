@php
    $activeList = 'users';
@endphp
@includeWhen(isset($arraySearchWords), 'commons.search_result_text', [
    'subjects' => $users,
    'subjectsName' => 'ユーザー',
]);
<ul class="list-unstyled">
    @foreach ($users as $user)
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($user->email, 55) }}" alt="ユーザのアバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $user->id) }}">{{ $user->name }}</a>
                </p>
            </div>
        </li>
    @endforeach
</ul>

@include('commons.index_pagination', ['subjects' => $users]);
