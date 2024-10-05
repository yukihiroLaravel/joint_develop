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

        // ページ内のvideoタグで再生中のものは停止する。
        stopAllPlayingVideos();

        /*
            イベントが発生した
            <div id="carousel{{ $strPostIdPostfix }}" class="carousel slide" data-ride="carousel" data-interval="false">
            の要素を$(this)で取得する
        */
        let carousel = $(this);

        // 最も近い祖先でclass属性にmodalを持つ要素を取得する。
        let modal = carousel.closest('.modal');

        /*
            どうしても、carousel.cssではvideoタグの大きさ調整がうまくいかなかった
            そこで、javascriptのコードでvideoタグの大きさ調整を試みたが
            元の動画のサイズが小さかった場合、枠だけ大きくなって結局、動画の再生部分は
            小さくなって、枠の一部でしか動作再生されないような特性があった

            後でわかったことだが、style.widthなどではなく
            直接的に、<videに、widthを書く方式だと
            「枠の一部でしか動作再生されないような特性」はないようだ
            この件は、
            app/PostImage.php
            に、
            ★★★widthを固定にする一旦の処置★★★
            で書いている。

            縦スクロールが発生しているケースで、
            スクロール位置が0となって表示するため、動画の再生ボタンのUIが
            下のほうにあるなどして、スクロール位置を下に下げないと
            再生ボタンが押せない状況となった。

            これは気持ち悪いため、縦スクロールが出ているケースでは、
            スクロール位置を一番下に下げる対応をした。

            javascriptはシングルスレッドモードで動作するなどがあり、
            setTimeout(function() { で、再度、スレッド起動させる方式をとらないと
            うまく動かなかった。
            1msのsetTimeoutでよい。
            1msという時間ではなく、別スレッドで行うことが重要だった。
        */
       let modalBody = modal.find('.modal-body');

        // jqueryオブジェクトのmodalより、DOMの要素を取得
        let modalBodyDom = modalBody[0];

        // <div class="modal-body">の配下でvideoタグを取得
        let video = modalBodyDom.querySelector('video');
        if (video) {
            // 動画のカルーセルページの場合だけ、下記を適用する。

            setTimeout(function() {
                // modal-bodyに縦スクロールが発生している場合は、一番下にスクロール位置を持っていく
                if (modalBody[0].scrollHeight > modalBody[0].clientHeight) {
                    modalBody.scrollTop(modalBody[0].scrollHeight);
                }
    
                // modal-bodyに横スクロールが発生している場合は、一番左にスクロール位置を持っていく
                if (modalBody[0].scrollWidth > modalBody[0].clientWidth) {
                    modalBody.scrollLeft(0);
                }
           }, 1);    
        }

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

    // カルーセルのモーダルが閉じられるときのイベントハンドラ
    $('[id^="imageModal"]').on('hidden.bs.modal', function () {
        // ページ内のvideoタグで再生中のものは停止する。
        stopAllPlayingVideos();
    });
});
