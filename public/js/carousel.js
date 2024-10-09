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

        /*
            どうしても、carousel.cssではvideoタグの大きさ調整がうまくいかなかった

            javascriptで調整するしかない

            let video = carousel[0].children[0].children[currentIndex].querySelector('video');
            だと今のカルーセルのページでのvideoタグを正確に取得できるようだ。

            縦横の比率が動画によって、バラバラであるが

            video.width = modalBody[0].clientWidth * 「倍率」;
            としておけば、
            縦幅は元の動画の縦横比をキープしたまま、拡大縮小される

            「倍率」を段階的に大きい値から小さい値に段階的に小さくしながら
            縦スクロールがなくなるまでするが

            ある程度のところで、打ち切る

            上記でもまだ、縦スクロールが発生しているケースで、
            動画の再生ボタンのUIが下のほうにあるので、
            スクロール位置を一番下に下げて、再生ボタンが見えてる状況とする。

            javascriptはシングルスレッドモードで動作するなどがあり、
            setTimeout(function() { で、再度、スレッド起動させる方式をとらないと
            うまく動かなかった。
            1msのsetTimeoutでよい。
            1msという時間ではなく、別スレッドで行うことが重要だった。
        */
        let modalBody = modal.find('.modal-body');

        // サイズ調整すべきターゲット
        let sizeAdjustTarget = null;
        // サイズ調整すべきアスペクト比
        let sizeAdjustAspectRatio = null;

        let video = carousel[0].children[0].children[currentIndex].querySelector('video');
        if (video) {
            sizeAdjustTarget = video;
        }
        let iframe = carousel[0].children[0].children[currentIndex].querySelector('iframe');
        if (iframe) {
            sizeAdjustTarget = iframe;

            /*
                viedeタグと異なり、YouTube動画のiframeタグは、
                widthを指定しても、heightが調整されない。結果的に横長になってなってしまった

                ただし、YouTube動画では、ほとんどの動画のアスペクト比が16:9であるとのこと
                ですので、16:9になるようにheightを自動調整すればよい。
            */
            sizeAdjustAspectRatio = (9 / 16);
        }
        if (sizeAdjustTarget) {
            // 動画のカルーセルページの場合だけ、下記を適用する。

            setTimeout(function() {

                /*
                    なるべくぴったりフィットを目指したいので、多めの倍率から横幅調整し、
                    縦スクロールがなくなった時点で、サイズ調整を終える。
                */
                let ratioArray = [0.95, 0.9, 0.85, 0.8, 0.75, 0.7, 0.65, 0.6, 0.55, 0.5, 0.45, 0.4, 0.35, 0.3];
                for(let index = 0 ; index < ratioArray.length ; ++index) {
                    let currentRatio = ratioArray[index];
                    sizeAdjustTarget.width = modalBody[0].clientWidth * currentRatio;

                    if(sizeAdjustAspectRatio) {
                        sizeAdjustTarget.height = sizeAdjustTarget.width * sizeAdjustAspectRatio;
                    }

                    // 縦スクロールが発生しているかどうか
                    let isHeightScroll = (modalBody[0].scrollHeight > modalBody[0].clientHeight);
                    if(!isHeightScroll) {
                        // 
                        /*
                            縦スクロールが発生していない今の横幅を基点とした
                            元画像の縦横比率キープでの大きさ調整に
                            縦スクロールが発生せず、ピッタリフィットの状況だと言えたので、
                            ここで、サイズ調整を終える。
                        */
                        break;
                    }
                }

                /*
                    上記でのサイズ調整プロセスでも、縦スクロールが発生してしまう状況であれば
                    画像によっては、縦横比の関係でそのようなものもあるでしょう。
                    そのときは、下部の再生ボタンが見えるように、
                    縦スクロール位置を一番下に持っていこう
                    また、ついでに、横スクロール発生時は、一番左の調整もやっておこう
                */

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
