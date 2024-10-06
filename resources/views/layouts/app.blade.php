<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>Topic Posts</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('/css/followButton.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/darkmodeButton.css') }}">
    </head>
    <body>
        @include('commons.header')
        <div class="container">
            @yield('content')
        </div>

        <!-- ダークモード切り替えボタン -->
        <button id="dark-mode-toggle" class="dark-mode-btn">
            <i class="fas fa-moon"></i>
        </button>

        @include('commons.footer')
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
        <script>
            // ダークモード切り替え機能
            const darkModeToggle = document.getElementById('dark-mode-toggle');
            const currentTheme = localStorage.getItem('theme') ? localStorage.getItem('theme') : null;
    
            if (currentTheme) {
                document.body.classList.add(currentTheme);
                if (currentTheme === 'dark-mode') {
                    darkModeToggle.innerHTML = '<i class="fas fa-sun"></i>';
                }
            }
    
            darkModeToggle.addEventListener('click', () => {
                document.body.classList.toggle('dark-mode');

                // ダークモードが有効な場合
                if (document.body.classList.contains('dark-mode')) {
                    darkModeToggle.innerHTML = '<i class="fas fa-sun"></i>';
                    localStorage.setItem('theme', 'dark-mode');
                } else {
                    darkModeToggle.innerHTML = '<i class="fas fa-moon"></i>';
                    localStorage.removeItem('theme');
                }
            });
        </script>
    </body>
</html>
