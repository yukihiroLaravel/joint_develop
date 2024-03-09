<div class="d-flex justify-content-center">
    @if (isset($searchWords))
        {{ $subjects->appends(['activeList' => $activeList, 'searchWords' => $searchWords])->links('pagination::bootstrap-4') }}
    @else
        {{ $subjects->appends(['activeList' => $activeList])->links('pagination::bootstrap-4') }}
    @endif
</div>
