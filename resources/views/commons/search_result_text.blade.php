@php
    $searchedWords = implode('",' . "\n" . '"', $arraySearchWords);
@endphp
<h5 class="text-center mt-4 mb-4">
    <span
        class="searched_words">"{{ $searchedWords }}"</span>が含まれる{{ $subjectsName }}の検索結果{{ $subjects->count() == 0 ? 'は0件でした。' : '' }}

</h5>
