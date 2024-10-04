<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>{{ config('app.TopicPostsTitle') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('/css/styles.css') }}">
    </head>
    <body class="d-flex flex-column">
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        {{-- 処理中を表すスピナー --}}
        <div id="processingSpinner" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 9999;">
            <div class="spinner-border text-light" role="status" style="width: 3rem; height: 3rem; position: absolute; top: 50%; left: 50%; margin-top: -1.5rem; margin-left: -1.5rem;">
                <span class="sr-only">Processing...</span>
            </div>
        </div>

        {{--
             トーストメッセージ出力エリア 
                フラッシュメッセージが画面上部であるため、画面のスクロール位置が下の方である場合に、
                メッセージが出力されたのかどうかがわかりにくいと感じたため、
                画面上部のフラッシュメッセージに連動してトーストメッセージを画面中央に表示する対応とした。
        --}}
        <div id="toastContainer" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1055;">
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="true" data-delay="3000">
                <div class="toast-body"></div>
            </div>
        </div>

        <script src="{{ asset('js/common.js') }}"></script>
        <script>
            /*
                DOMの構築の完了を待たずに、スピナーを表示する。
                「$(document).ready(function() {」はDOM構築が完了後に
                順番に実行されるため、submit系でのページ表示時にすぐに、スピナーを出すには
                この位置で<script>タグで表示する必要あり。
            */
            // スピナーを表示
            showSpinner();

            /*
                画面リロードから再表示完了までスピナーを表示するようにしたため
                途中でjavascriptエラーが発生時に、スピナーが表示されっぱなしになることを防ぎたい。
                ( 処理に時間がかかっているのか、エラーがあるのか判断できなくなるから )
                そのため、catchしてないjavascriptの例外を捕獲して
                スピナーを消す。
                その際、エラーの通知、および、詳細なデバッグ情報をconsole.error()をしておく
            */
            window.addEventListener('error', function (event) {
                let errorMessage = getErrorMessageOnGlobalError(event);

                let isAlert = true;
                /*
                    videoタグをカルーセルに入れてから、
                    カルーセルでページ切り替え中に、時々、
                    message : ResizeObserver loop completed with undelivered notifications.
                    のようなエラーメッセージで、ここに飛んでくる。原因不明である。

                    ただ、ここにエラーが飛んでくるだけで画面表示がおかしくなったりもしない
                    特に実害がないため、
                    ブラウザのデバッガーで見れるコンソールには出力しておくが、alert表示をしないことにした。
                */
                let specialError00100 = errorMessage.includes('ResizeObserver loop completed');
                if(specialError00100) {
                    isAlert = false;
                }

                console.error('エラーが発生しました:', errorMessage);

                if(isAlert) {
                    alert('エラーが発生しました');
                }
                
                // スピナーを消す
                hideSpinner();
            });

            $(document).ready(function() {
                $(document).on('submit', 'form', function(event) {
                    // スピナー表示をすべきかどうか
                    let isSpinner = true;
                    if (event.originalEvent) {
                        if(event.originalEvent.returnValue === false) {
                            /*
                                個別のformタグでonsubmitで「return false」した場合
                                 ( return confirm('XXX') でキャンセルを押した場合も該当 )
                                スピナー表示は行わない。
                            */
                            isSpinner = false;
                        }
                    }
                    if (isSpinner) {
                        // スピナーを表示
                        showSpinner();
                    }
                });

                /*
                    意味的には「@csrf」と同内容のことをajax版でもするための対応である
                    ページリロードごとに一回すればよく
                    タイミングの問題でこの位置がすべての機能の一番初めの位置なので、ここでやっておく
                    これをしておかないと非GETでの「$.ajax」にてエラーで、api側のコントローラーのメソッドまで制御が行かない
                */
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                /*
                    flash_client_message.blade.phpの#flashClientMessageは、
                    表示中に×で閉じる前に、再度、表示されたは、置き換えて表示し、
                    同じものを使いまわす方向性で実装している。

                    ×ボタンで閉じた後、ページリロードが発生する前に
                    再度、表示しようとすると表示できない問題があった。
                    (ajax通信結果の通の表示であれば、ページリロード前に再度、ajax通信の結果表示は有り得る)

                    ×ボタンに「data-dismiss="alert"」があると、DOMから削除されてしまうため
                    表示しようとする対象が無いため表示できない問題だった。
                    
                    flash_client_message.blade.phpで、×ボタンより
                    「data-dismiss="alert"」を取り除き、
                    closeイベントを上書きして、非表示するだけとした。
                    この対応により、×で閉じた後でも、再表示ができる状況にした。
                */
                $('#flashClientMessage .close').on('click', function() {
                    $('#flashClientMessage').hide();
                });
            });
        </script>

        <script src="{{ asset('js/flash_client_message.js') }}"></script>

        @include('commons.header')
        <div class="container mb-auto">
            @yield('content')
        </div>
        @include('commons.footer')

        <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>

        <script>
            $(document).ready(function() {
                // スピナーを消す
                hideSpinner();
            });
        </script>
    </body>
</html>
