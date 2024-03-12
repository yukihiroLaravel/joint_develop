@php
    $activeList = 'users';
@endphp
@includeWhen(isset($arraySearchWords), 'commons.search_result_text', [
    'subjects' => $users,
    'subjectsName' => 'ユーザー',
])
<ul class="list-unstyled d-flex align-items-center flex-column mt-4">
    @foreach ($users as $user)
        <li class="col-11 col-sm-10 col-lg-8 pt-3 pb-3">
            <div class="d-flex mb-2">
                <div class="mr-2" style="width: 55px">
                    @include('commons.user_icon', ['user' => $user])
                </div>
                <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $user->id) }}">{{ $user->name }}</a>
                </p>
            </div>
        </li>
    @endforeach
</ul>

@include('commons.index_pagination', ['subjects' => $users]);
