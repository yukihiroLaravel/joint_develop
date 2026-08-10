<style>
    /* 投稿詳細のSVGドーナツだけに適用する */
    #reaction-donut-chart svg {
        display: block;
        width: 100%;
        max-width: 520px;
        height: auto;
        overflow: visible;
    }

    /* 現在の中央円と同じ、直径130pxの背景円 */
    #reaction-donut-chart .reaction-donut-center {
        fill: #f8f9fa;
    }

    /* 円弧からリアクション情報へ伸ばすガイド線 */
    #reaction-donut-chart .reaction-donut-line {
        fill: none;
        stroke: #6c757d;
        stroke-width: 1.5;
    }

    /* ガイド線の先に表示するリアクション区分名 */
    #reaction-donut-chart .reaction-donut-label-name {
        fill: #343a40;
        font-size: 18px;
        font-weight: 700;
    }

    /* ガイド線の先に表示する件数・割合 */
    #reaction-donut-chart .reaction-donut-label-value {
        fill: #6c757d;
        font-size: 15px;
    }

    /*
     * スマホではラベルと線が重なりやすいためSVG内では非表示にする。
     * 区分名・件数・割合は、既存の凡例で確認できる。
     */
    @media (max-width: 767.98px) {
        #reaction-donut-chart svg {
            width: 220px;
        }

        #reaction-donut-chart .reaction-donut-annotation {
            display: none;
        }
    }
</style>