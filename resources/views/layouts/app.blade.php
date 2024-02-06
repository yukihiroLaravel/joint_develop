<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Topic Posts</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    @include('commons.header')

    <div class="container">
        <div class="center jumbotron bg-info">
            <div class="text-center text-white mt-2 pt-1">
                <h1><i class="pr-3"></i>Topic Posts</h1>
            </div>
        </div>
        <h5 class="text-center mb-3">"趣味や仕事"について140字以内で会話しよう！</h5>
        <!-- <div class="w-75 m-auto">エラーメッセージが入る場所</div> -->
        <div class="text-center mb-3">
            <form method="" action="" class="d-inline-block w-75">
                <div class="form-group">
                    <textarea class="form-control" name="" rows=""></textarea>
                    <!-- <div class="text-left mt-3"> -->
                        <!-- <button type="submit" class="btn btn-primary">投稿する</button> -->
                    <!-- </div> -->
                </div>
            </form>
        </div>

        @yield('content')
    </div>

    @include('commons.footer')

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
</body>
</html>
