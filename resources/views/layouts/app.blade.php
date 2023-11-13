<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>旅・旅行 Topic Posts</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <style>
            .alert-custom {
                display: inline-block;
                max-width: 100%;
                margin-top: 20px; /* 余白調整 */
            }
        </style>
    </head>
    <body>
        @include('commons.header')
        <div class="container">
            <!-- フラッシュメッセージの表示 -->
            @if (session('status'))
                <div class="alert alert-success alert-custom">
                    {{ session('status') }}
                </div>
            @endif
            @yield('content')
        </div>
        @include('commons.footer')
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                console.log("Document is ready");

                setTimeout(function() {
                    console.log("Starting fadeOut");

                    var alerts = document.querySelectorAll('.alert');
                    for (var i = 0; i < alerts.length; i++) {
                        fadeOut(alerts[i], function() {
                            console.log("FadeOut completed");
                        });
                    }
                }, 5000);
            });

            function fadeOut(element, callback) {
                var op = 1;  // initial opacity
                var timer = setInterval(function() {
                    if (op <= 0.1) {
                        clearInterval(timer);
                        element.style.display = 'none';
                        if (callback) callback();
                    }
                    element.style.opacity = op;
                    element.style.filter = 'alpha(opacity=' + op * 100 + ")";
                    op -= op * 0.1;
                }, 50);
            }
        </script>
    </body>
</html>