/**
 * スピナーを表示
 */
function showSpinner() {
    $('#processingSpinner').show();
}

/**
 * スピナーを消す
 */
function hideSpinner() {
    $('#processingSpinner').hide();
}

/**
 * onsubmitのキャンセル
 */
function stopSubmit(event) {
    // sumitを抑制
    event.preventDefault();
    event.stopPropagation();
}

// フラッシュメッセージを消す。
function hideFlashMessages() {
    $('.myserver-flash-marking').remove();
    $('#flashClientMessage').hide();
}

// トーストメッセージを表示する。
function showToast(message) {

    /*
        フラッシュメッセージの表示エリアが、
        画面上部であるため、スクロール位置が下のほうであるときに
        メッセージが出ていることがわかりにくいため
        トーストメッセージも併用することにした。
    */

    // トーストの要素取得
    var $toast = $('#toastContainer .toast');

    // メッセージを指定する。
    $toast.find('.toast-body').text(message);

    // 表示
    $toast.toast('show');
}

function showToast(message, alertClass) {
    // トーストの要素取得
    var $toastBody = $('#toastContainer .toast-body');

    // トーストボディのクラスをリセット(背景色をリセット)
    $toastBody.removeClass('alert-success alert-danger alert-warning alert-info');

    // トーストボディのクラスに新しいalertクラスを追加(背景色を設定)
    $toastBody.addClass('alert-' + alertClass);

    // メッセージを設定
    $toastBody.text(message);

    // トーストを表示
    $('#toastContainer .toast').toast('show');
}

// iframeが指定されたYT.Playerのリスト
let ytPlayers = [];

// 「YouTube IFrame API」の「onYouTubeIframeAPIReady」で実行されるべき処理
function procOnYouTubeIframeAPIReady() {

    /*
        onYouTubeIframeAPIReady の関数名は、
        「YouTube IFrame API」の仕様で決まっている

        「YouTube IFrame API」が準備OKになったら動く
    */
    const iframes = document.querySelectorAll('iframe');
    iframes.forEach((iframe, index) => {
        if (iframe.src.includes('youtube.com')) {
            loadYtPlayer(iframe);
        }
    });
}

// 読み込まれたiframeでYT.Playerを初期化して、ytPlayersに追加する。
function loadYtPlayer(iframe) {
    const player = new YT.Player(iframe, {
        events: {
            'onReady': function(event) {
                ytPlayers.push(player);
            },
            'onError': function(event) {
                console.log("####  Error loading player iframe: ", iframe.src, event.data);
            },
        }
    });
}

/**
 * ページ内の動画で再生中のものは停止する。
 */
function stopAllPlayingVideos() {

    /*
        再生中の動画を停止の操作をせずに、

        カルーセルのページ切り替え後も、切替前のページの動画が再生状態のまま(裏で音声だけ聞こえる)
        カルーセルを閉じた後も、動画が再生状態のまま(裏で音声だけ聞こえる)

        状態を防ぐために、イメページ内にある動画について、停止の操作を行っておく。
    */

    // ページ内の全てのvideoタグを取得
    const videos = document.querySelectorAll('video');

    videos.forEach(video => {
        if (!video.paused) {
            // 再生中のvideoの場合

            // 再生を停止する
            video.pause();
            // 別ページに遷移などで該当のvideoタグがDOMから消えるまでは
            // 再生位置をキープしたいため、一旦、コメントアウト(初期の再生位置に戻したいかは仕様次第)
            //*** // 再生位置を最初に戻す
            //*** video.currentTime = 0;
        }
    });

    ytPlayers.forEach(player => {
        player.pauseVideo();
    });
}

/**
 * ページ内の一番最後の「$(document).ready(function() {」ですべき処理
 * 
 * ブラウザのデバッガーで確認しずらいためfunction化した。
 */
function lastReadyProc() {
    /*
        <script src="https://www.youtube.com/iframe_api"></script>
        は、「YouTube IFrame API」を使えるようにするためのものである
        「new YT.Player()」のために必要である。
        「&enablejsapi=1」をyoutubeのURLに付与してる状況で正しく動作する。

        onYouTubeIframeAPIReady は、
        「YouTube IFrame API」の仕様で決まっている
        「YouTube IFrame API」が準備OKになったら動く

        <script src="https://www.youtube.com/iframe_api"></script>
        の方式でやろうとしたが、その場合は、onYouTubeIframeAPIReadyが動くタイミングでは、
        DOM上に一部のiframeしか作成されていないタイミングであった。

        そのため、ページの下の方にあるiframeについて、動画を停止させる制御がうまく動かなかった。

        そこで、ページの一番下で実行される
            $(document).ready(function() {
        の当実装にて、動的に、
            $.getScript("https://www.youtube.com/iframe_api", function() {
        で、
            「YouTube IFrame API」の読み込みを行うことにした。
        ページの一番下で実行される

        「  $(document).ready(function() {  」の当実装では、DOMが全て作成済のタイミングであるからだ。
        
        このようにして、意図通り、ページ内のyoutubeのiframeの全てに対して動画を停止させる制御が働くように配慮してます。
    */

    window.onYouTubeIframeAPIReady = function() {
        console.log("onYouTubeIframeAPIReady");
        
        // 「YouTube IFrame API」の「onYouTubeIframeAPIReady」で実行されるべき処理
        procOnYouTubeIframeAPIReady();
    };

    // 「YouTube IFrame API」を使えるようにする。「new YT.Player()」のために必要である。「&enablejsapi=1」をyoutubeのURLに付与するのが必要である。
    $.getScript("https://www.youtube.com/iframe_api", function() {
        console.log("YouTube IFrame API script loaded.");
    });
}

/**
 * urlからyoutubeIdを取得する。
 */
function getYouTubeId(url) {
    let youtubeId = null;

    if (!youtubeId) {
        youtubeId = getYouTubeIdSubLogic(url, "https://www.youtube.com/watch?v=", "v=");
    }
    if (!youtubeId) {
        youtubeId = getYouTubeIdSubLogic(url, "https://youtu.be/", "youtu.be/");
    }
    if (!youtubeId) {
        youtubeId = getYouTubeIdSubLogic(url, "https://www.youtube.com/embed/", "embed/");
    }
    if (!youtubeId) {
        youtubeId = getYouTubeIdSubLogic(url, "https://www.youtube.com/v/", "v/");
    }
    if (!youtubeId) {
        youtubeId = getYouTubeIdSubLogic(url, "https://www.youtube.com/shorts/", "shorts/");
    }

    return youtubeId;
}

/**
 * urlからyoutubeIdを取得する。(サブロジック)
 */
function getYouTubeIdSubLogic(url, pattern, splitString) {
    if (url.startsWith(pattern) && url.length >= pattern.length + 11) {
        // URLがpatternで始まっていて、かつ、URL全体の長さが「patternの文字数 + 11」以上の場合

        // splitStringで分割
        const splitResult = url.split(splitString);
        
        if (splitResult.length > 1 && splitResult[1].length >= 11) {
            /*
              splitResult[1]が存在し、かつ長さが11文字以上であることを確認
              次の11桁内にsplitResultが含まれていないので、
              次の11桁を取得可能な状況の場合
            */
            const youtubeId = splitResult[1].substring(0, 11);
            return youtubeId;
        }
    }
    return null;
}

/**
 * youtubeIdを指定して、YouTube動画のサムネイル画像のURLを取得する。
 */
function getYoutubeThumbnailUrl(youtubeId)
{
    thumbnailRelativeFilePath = `https://img.youtube.com/vi/${youtubeId}/hqdefault.jpg`;
    return thumbnailRelativeFilePath;
}

/**
 *  「window.addEventListener('error', function (event) {」
 *  グローバルにcatchしてないjavascript例外を捕獲した時のeventオブジェクトより
 *  詳細なデバッグ情報のあるerrorMessageを取得する。
 */
function getErrorMessageOnGlobalError(event) {
    let errorMessage = `message : ${event.message}  source : ${event.filename}:${event.lineno}:${event.colno}`;
    if (event.error) {
        if (event.error.stack) {
            errorMessage += `stacktrace : ${event.error.stack}`;
        }
    }
    return errorMessage;
}

/*
    ファイルの種類に関する知識を当クラスに集約し、
    各種アプリ内のコードに分散させたくない。
    ファイルの種類ごとの各種ハンドリングを当クラスの責務としたい。

    ★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    注意事項
    ★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    しかし、フロントエンド間と、バックエンド間で分散してしまった。
    完全に同じ実装ではないが、関係する箇所は、
    app/Helpers/FileType.phpと同期をとったメンテナンスをすること！！
    ★★★★★★★★★★★★★★★★★★★★★★★★★★★★
*/
class FileType {

    static IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif'];
    static VIDEO_EXTENSIONS = ['mp4', 'webm', 'ogv', 'm4v'];

    // youTubeの拡張子(実際には存在しない拡張子だが、upload.jsにて、youtubeIdに、この拡張子を付与する形でファイル名を指定している)
    static YOUTUBE_EXTENSIONS = ['youtube'];

    constructor(argFileName) {
        this.fileName = argFileName;

        // ファイルの拡張子を取得して小文字に変換
        const extension = this.fileName.split('.').pop().toLowerCase();

        // 画像ファイルかどうか
        this.isImage = FileType.IMAGE_EXTENSIONS.includes(extension);

        // 動画ファイルかどうか
        this.isVideo = FileType.VIDEO_EXTENSIONS.includes(extension);

        // youTubeかどうか
        this.isYoutube = FileType.YOUTUBE_EXTENSIONS.includes(extension);

        this.youtubeId = "";

        if(this.isYoutube) {
            const tempArray = this.fileName.split(".");
            this.youtubeId = tempArray[tempArray.length - 2];
        }

        /*
            特記事項
            「 && !$this.isYoutube」の連結はあえて行わない

            バリデーションチェックなどに影響ある。
            this.isYoutubeの時は、完全に別ロジック対応です。
            間違って、バリデーションチェックが動いても
            this.isOtherのときと同じ、NGにしておきたい。

            おそらくないと思うが、.youtube の拡張子のテキストファイルなどを
            アップロードしてきたときに、誤動作にならいように、
            $this->isOtherとしてのバリデーションチェックが働く形としたい
            このような意図があり、
            「 && !$this.isYoutube」の連結はあえて行わない
        */
        // どちらにも該当しない場合
        this.isOther = !this.isImage && !this.isVideo;
    }

    /*
        アップロードに関してバリデーションチェックをする(クライアント側)
    */
    validate(
        // 動画のアップロードが可能なモードかどうか
        isEnableVideo,

        // 1ファイルあたりの最大アップロードサイズ(単位:MB)
        uploadMaxFilesize,

        // 画像の場合の仕様で決めたアップロードの最大サイズ(単位:MB)
        uploadImageMaxFilesize,

        // 今回、アップロードしようとしているファイルのサイズ(単位:バイト数)
        fileSize
    )
    {
        let allowedExtensions;
        if (isEnableVideo) {
            // 動画と画像両方の拡張子を連結してカンマ区切りにする
            allowedExtensions = [...FileType.IMAGE_EXTENSIONS, ...FileType.VIDEO_EXTENSIONS].join(', ');
        } else {
            // 画像の拡張子のみをカンマ区切りにする
            allowedExtensions = FileType.IMAGE_EXTENSIONS.join(', ');
        }

        if (this.isOther) {
            return `アップロード可能な「ファイル」は「${allowedExtensions}」です。`;
        }

        if (!isEnableVideo) {
            // 動画のアップロードが許可されていない場合

            if(this.isVideo) {
                // 動画を指定した場合

                return `アップロード可能な「ファイル」は「${allowedExtensions}」です。`;
            }
        }

        if(this.isVideo) {
            if(fileSize > (uploadMaxFilesize * 1024 * 1024) ) {
                return `アップロード可能な「動画」は${uploadMaxFilesize}MB以内です。`;
            }
        }

        if(this.isImage) {
            if(fileSize > (uploadImageMaxFilesize * 1024 * 1024) ) {
                return `アップロード可能な「画像」は${uploadImageMaxFilesize}MB以内です。`;
            }
        }

        return null;
    }

    /**
     * baseのディレクリ名を返す
     * 
     * storage/XXX/{type}/{uuid}/{fileName}
     * のパスのうち、XXXの部分に相当する
     */
    getBaseDirName()
    {
        if(this.isImage) {
            return "images";
        }
        if(this.isVideo) {
            return "videos";
        }

        throw new Exception("不正な状況");
    }
}
