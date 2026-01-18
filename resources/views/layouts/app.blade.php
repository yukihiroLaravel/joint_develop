<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>エンジニアの森</title>
        <style>
            body {
                background-image: url("{{ asset('image/forest-bg.jpg') }}");
                background-size: cover;
                background-position: center top;
                background-attachment: fixed;
                background-repeat: no-repeat;
                min-height: 100vh;
                margin: 0;
                padding-bottom: 120px;
            }

            /* コンテンツエリア */
            .container {
                background-color: rgba(255, 255, 255, 0.8); 
                border-radius: 15px;
                padding: 30px;
                margin-top: 20px;
            }

            /* 動物たち */
            .animal-parade {
                display: block;
                width: 100%;
                height: 250px;
                background-image: url("{{ asset('image/animals.png') }}");
                background-repeat: repeat-x;
                background-size: contain;
                background-position: bottom center;
                pointer-events: none;
            }

            /* ヘッダー全体 */
            .navbar {
                background-color: #a3d39c !important;
                border-bottom: 3px solid #8dbd87;
            }

            /* 共通の文字色（濃い緑） */
            .navbar-brand, .nav-link, .brand-text, h1 {
                color: #4a5d45 !important;
                font-weight: bold;
            }

            /* 水色背景を完全に消す（ヘッダーも中央もこれ1つでOK） */
            .bg-info, .jumbotron {
                background: transparent !important;
                background-color: transparent !important;
                box-shadow: none !important;
            }

            /* 中央のタイトルと木を大きく、緑にする */
            h1 {
                font-size: 3.5rem !important; /* ここで大きさを一括管理 */
                text-align: center;
            }

            .fa-tree, svg.svg-inline--fa.fa-tree {
                color: #2d5a27 !important; /* 木の緑 */
                fill: #2d5a27 !important;
                font-size: 0.8em;
                margin: 0 10px;
            }
        </style>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet">
    </head>
    <body>
        @include('commons.header')
        <div class="container">
            @yield('content')
        </div>
        <div class="animal-parade"></div>
        @include('commons.footer')
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
        <script>
            document.querySelectorAll('#tags').forEach(function(el) {
                new Tagify(el, {
                    delimiters: " ",
                    originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(' ')
                });
            });
        </script>
    </body>
</html>
