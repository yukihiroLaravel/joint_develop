@if (isset($arraySearchWords))
    @php
        $searchedWords = implode('",' . "\n" . '"', $arraySearchWords);
    @endphp
    <h5 class="text-center mt-4 mb-4">
        @if ($users->count() == 0)
            <span class="searched_words">"{{ $searchedWords }}"</span>が含まれるユーザーはいませんでいた。
        @else
            <span class="searched_words">"{{ $searchedWords }}"</span>を名前に含むユーザーの検索結果
        @endif
    </h5>
@endif
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
<div class="d-flex justify-content-center">
    @php
        $activeList = 'users';
    @endphp
    @if (isset($searchWords))
        {{ $users->appends(['activeList' => $activeList, 'searchWords' => $searchWords])->links('pagination::bootstrap-4') }}
    @else
        {{ $users->appends(['activeList' => $activeList])->links('pagination::bootstrap-4') }}
    @endif
</div>
