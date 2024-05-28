@if ($posts->isEmpty() && !empty($keyword))
    <ul class="alert alert-success" role="alert">
        <li class="ml-4">検索結果はありません。</li>
    </ul>
@endif
