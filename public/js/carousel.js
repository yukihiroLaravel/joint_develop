$(document).ready(function() {
    /**
     * 引数のmodalが
     * <div class="modal fade" id="imageModal{{ $strPostIdPostfix }}" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
     * の要素を表していることを前提にして、配下の
     * <input type="hidden" value="{{ $strPostIdPostfix }}" class="strPostIdPostfix">
     * をfindし、その値のstrPostIdPostfixを取得して返す
     */
    function getStrPostIdPostfix(modal) {
        // 配下のinput要素でclassがstrPostIdPostfixである要素の値を取得する。
        let strPostIdPostfix = modal.find('input.strPostIdPostfix').val();
        return strPostIdPostfix;
    }

    // サムネイルをクリック時に、そのorder値の画像表示でスライドを表示する。
    $('[id^="imageModal"]').on('show.bs.modal', function (event) {

        // クリックされたサムネイル画像のimgタグを取得
        let clicThumbnailImg = $(event.relatedTarget);

        // 「data-slide-to=」で指定された値を取得する。
        let slideIndex = clicThumbnailImg.data('slide-to');

        /*
            クリックしたサムネイル画像の
            data-target=\"#imageModal{$strPostIdPostfix}\"
            で関連づけられた当事者となっている
            #imageModal{$strPostIdPostfix}
            の要素を$(this)で取得する。
        */
        let modal = $(this);

        // strPostIdPostfixを取得する。
        let strPostIdPostfix = getStrPostIdPostfix(modal);

        // クリックしたサムネイルに対応した画像でスライドを表示する。
        $('#carousel' + strPostIdPostfix).carousel(slideIndex);
    });

    // prev/nextボタンを押した時
    $('[id^="carousel"]').on('slid.bs.carousel', function () {
        /*
            イベントが発生した
            <div id="carousel{{ $strPostIdPostfix }}" class="carousel slide" data-ride="carousel" data-interval="false">
            の要素を$(this)で取得する
        */
        let carousel = $(this);

        // 最も近い祖先でclass属性にmodalを持つ要素を取得する。
        let modal = carousel.closest('.modal');

        // strPostIdPostfixを取得する。
        let strPostIdPostfix = getStrPostIdPostfix(modal);

        /*
            jqueryのshow()、hide()が効かず
            また、carousel-control-prev、carousel-control-nextのclass属性値を
            add()、remove()しなければ、
            prev、nextの表示／非表示の制御ができなかった
            ( 完全に非表示にならなかったなどの問題点があった )
            上記の問題点を解消するため試行錯誤した結果
            jqueryでの取得ではなく、通常のDOM操作での取得方式が
            どうしても必要だったため、局所的にそうしています。
        */
        var prevDiv = document.getElementById('prevDiv' + strPostIdPostfix);
        var nextDiv = document.getElementById('nextDiv' + strPostIdPostfix);

        var imgLength = parseInt(document.getElementById('imgLength' + strPostIdPostfix).value);

        /*
            サムネイル画像をクリックしスライドを起動した時、
            prev、nextでスライドを切り替えた時、
            には表示すべき画像についてのcarousel-itemをclass属性値を持つ要素に
            自動的にactiveのclass属性値が指定される。
            (他のcarousel-itemをclass属性値を持つ要素からはactiveは消える)

            その状況を利用して、carousel要素の配下で、
            carousel-itemをclass属性値として持つ、且つ、activeをclass属性値として持つ
            要素を探す。

            .index()は、その要素が兄弟要素の中での0はじまりのindexを返す
        */       
        var currentIndex = carousel.find('.carousel-item.active').index();

        // 最初のスライドはprevを非表示
        if (currentIndex === 0) {
            prevDiv.style.visibility = 'hidden';
            prevDiv.classList.remove('carousel-control-prev');
        } else {
            prevDiv.style.visibility = 'visible';
            prevDiv.classList.add('carousel-control-prev');
        }

        // 最後のスライドはnextを非表示
        if (currentIndex === (imgLength-1)) {
            nextDiv.style.visibility = 'hidden';
            nextDiv.classList.remove('carousel-control-next');
        } else {
            nextDiv.style.visibility = 'visible';
            nextDiv.classList.add('carousel-control-next');
        }
    });

    /*
        モーダルが開いたときの初期化とのこと
        詳細はよくわからないが、これをお作法としてやっとかないと
        意図通り動いてくれないとのこと
    */
    $('[id^="imageModal"]').on('shown.bs.modal', function () {
        var modal = $(this);

        // strPostIdPostfixを取得する。
        let strPostIdPostfix = getStrPostIdPostfix(modal);

        $('#carousel' + strPostIdPostfix).trigger('slid.bs.carousel');
    });
});
