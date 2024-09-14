@php
    // $postに紐づく「post_images」をorder順に取得
    $postImages = $post->postOrderImages()->get();
    if ($postImages->isEmpty()) {
        return;
    }

    $postImagesLength = $postImages->count();

    // 当実装は各々の$postを意識して複数箇所にてインクルードされるためid属性の重複を避けるため、$post->idより前ゼロ補充で作った文字列を付与する
    $strPostIdPostfix = sprintf('%020d', $post->id);
@endphp

{{-- ＜＜cssの読み込みをここでやっている経緯の説明＞＞ --}}
{{-- resources/views/layouts/app.blade.php --}}
{{-- での下記cssを定義していたが、他画面のレイアウトに影響があったため ( ユーザ編集の退会時の確認ダイアログのレイアウトが崩れた ) --}}
{{-- それを回避するためこの位置でのcarousel.cssの読み込みとした。 --}}
{{-- DOMツリー上、この配下にだけ、carousel.cssを適用させるため --}}
{{-- 各々の$postにて複数箇所にてインクルードされる、その各々について互いに干渉することなく --}}
{{-- 独立的に、同じcarousel.cssのスタイルが適用され、上位のDOMツリーには影響しないという意味となる。 --}}
<link rel="stylesheet" href="{{ asset('/css/carousel.css') }}">
{{-- 上記の理屈は、carousel.js も同様であり、影響範囲を局所化したいため、この位置で読み込む --}}
<script src="{{ asset('js/carousel.js') }}"></script>

{{-- サムネイル画像 --}}
<div class="thumbnail-wrapper">
    @foreach ($postImages as $postImage)
        {!! $postImage->getThumbnailImg($strPostIdPostfix) !!}
    @endforeach
    <input type="hidden" id="imgLength{{ $strPostIdPostfix }}" value="{{ $postImagesLength }}">
</div>

{{-- モーダル「curselでのprev/nextでの大き目サイズで画像表示」 --}}
<div class="modal fade" id="imageModal{{ $strPostIdPostfix }}" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">

    {{-- carousel.js内から「strPostIdPostfix」の値を取得できるようにhidden項目を置いておく --}}
    <input type="hidden" value="{{ $strPostIdPostfix }}" class="strPostIdPostfix">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            {{-- prevボタン --}}
            <a id="prevDiv{{ $strPostIdPostfix }}" class="carousel-control-prev" href="#carousel{{ $strPostIdPostfix }}" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>

            {{-- 画像表示部分 --}}
            <div class="modal-body">
                {{-- 「data-interval="false"」を指定して一定時間ごとに自動的にカルーセルが次へ進んでしまうのを無効にする。 --}}
                <div id="carousel{{ $strPostIdPostfix }}" class="carousel slide" data-ride="carousel" data-interval="false">
                    <div class="carousel-inner">
                        @foreach ($postImages as $postImage)
                            @php
                                /*
                                    初期で1つ目の要素にだけ、class値「active」を指定してる状況でないと
                                    意図した動作をしてくれないことが判明したため、その対応。
                                */
                                $divCarouselItemActive = '';
                                if($postImage->order === 0) {
                                    // 先頭に半角スペースを一つ指定
                                    $divCarouselItemActive = ' active';
                                }
                            @endphp
                            <div class="carousel-item{{ $divCarouselItemActive }}">
                                {!! $postImage->getCarouselItemImg() !!}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- nextボタン --}}
            <a id="nextDiv{{ $strPostIdPostfix }}" class="carousel-control-next" href="#carousel{{ $strPostIdPostfix }}" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>

            {{-- 右上の閉じるボタン --}}
            <button type="button" class="modal-close-btn" data-dismiss="modal">×</button>
        </div>
    </div>
</div>
