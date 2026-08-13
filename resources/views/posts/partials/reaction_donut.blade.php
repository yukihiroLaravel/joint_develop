{{-- リアクション割合のドーナツと、区分ごとの凡例を表示する部品 --}}

@php
    /*
     * JavaScriptへ渡す、リアクション区分ごとの表示データ。
     * 件数・割合・色は、親のshow.blade.phpでControllerから受け取っている値を使う。
     */
    $reactionChartData = [];

    foreach ($reactionTypes as $type => $label) {
        $reactionChartData[] = [
            'type' => $type,
            'label' => $label,
            'count' => $reactionCounts[$type] ?? 0,
            'percentage' => $reactionPercentages[$type] ?? 0,
            'color' => $reactionColors[$type] ?? '#adb5bd',
        ];
    }
@endphp

{{-- JavaScriptが読み取る、リアクション集計データ --}}
<script id="reaction-donut-data" type="application/json">
    @json($reactionChartData)
</script>

{{-- 集計カード右側に配置するドーナツ部品 --}}
<div class="col-md-5 d-flex flex-column align-items-center">
    <p class="font-weight-bold mb-3">
        リアクション割合
    </p>

    {{-- JavaScriptがSVGドーナツを追加する表示領域 --}}
    <div
        id="reaction-donut-chart"
        class="mb-4"
        role="img"
        aria-label="リアクション割合。合計{{ $totalReactions }}件"
    ></div>

    {{-- JavaScriptが無効な場合は、従来の静的ドーナツを表示する --}}
    <noscript>
        <div
            class="rounded-circle d-flex align-items-center justify-content-center mb-4"
            style="width: 220px; height: 220px; background: {{ $donutBackground }};"
        >
            {{-- 現在と同じ、直径130pxの中央表示 --}}
            <div
                class="rounded-circle bg-light d-flex flex-column align-items-center justify-content-center shadow-sm"
                style="width: 130px; height: 130px;"
            >
                <span class="text-muted small">
                    計
                </span>

                <span class="font-weight-bold h4 mb-0">
                    {{ $totalReactions }}
                </span>

                <span class="text-muted">
                    件
                </span>
            </div>
        </div>
    </noscript>

    {{-- 区分ごとの色・名称・件数・割合を示す既存の凡例 --}}
    <div class="w-100" style="max-width: 260px;">
        @foreach ($reactionTypes as $type => $label)
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="d-flex align-items-center">
                    <span
                        class="rounded-circle d-inline-block flex-shrink-0 mr-2"
                        style="width: 12px; height: 12px; background-color: {{ $reactionColors[$type] ?? '#adb5bd' }};"
                    ></span>

                    <span class="font-weight-bold">
                        {{ $label }}
                    </span>
                </div>

                <span class="text-nowrap">
                    {{ $reactionCounts[$type] ?? 0 }}件
                    ({{ $reactionPercentages[$type] ?? 0 }}%)
                </span>
            </div>
        @endforeach
    </div>
</div>