<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Topic Posts</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .form-group {
            display: none; /* フォームを非表示にするスタイル */
        }
    </style>
</head>
<body>

    @include('commons.header') 

    <div class="container">
        <div class="center jumbotron bg-info">
            <div class="text-center text-white mt-2 pt-1">
                <h1><i class="fab fa-telegram fa-lg pr-3"></i>Topic Posts</h1>
            </div>
        </div>
        <h5 class="text-center mb-3">"趣味や仕事"について140字以内で会話しよう！</h5>

        <div class="text-center mb-3">
            <form method="POST" action="{{ route('post.create') }}" class="d-inline-block w-75">
                <div class="form-group">
                    <textarea class="form-control" name="content" rows="3"></textarea>
                    <div class="text-left mt-3">
                        <button type="submit" class="btn btn-primary">投稿する</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- 投稿一覧を表示するコンテンツを追加 -->
        <div class="post-list">
            @include('toppage', ['$posts' => $posts])
        </div>

    </div>

    @include('commons.footer') 
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
</body>
</html>
