@if (session('successMessage'))
 <div class="alert alert-success text-center">{{ session('successMessage') }}</div>
@endif

<ul class="list-unstyled">
    @foreach ($posts as $post)
        @php
            $user = $post->user;
        @endphp
            <li class="mb-3 text-center">
                <div class="text-left d-inline-block w-75 mb-2">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($user->email, 55) }}" alt="ユーザのアバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $user->id) }}">{{ $user->name }}</a></p>
            </div>
            <div class="container">
                <div class="text-left d-inline-block w-75">
                    <p class="mb-2">{!! preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)@', '<a href="$1" target="_blank">$1</a>', e($post->text)) !!}</p>
                    <p class="text-muted">{{ $post->created_at }}</p>
                </div>
                @if (Auth::check() && Auth::id() === $post->user_id)
                    <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                        <form action="{{ route('post.delete', $post->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                        <a href="{{ route('post.edit', $post->id) }}" class="btn btn-primary">編集する</a>
                    </div>
                @endif
            </div>
        </li>
    @endforeach
</ul>
<div class="m-auto" style="width: fit-content">{{ $posts->links() }}</div>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>
</head>
<body>

<form action="" onsubmit="return false">
<textarea name="" id="js-text" cols="30" rows="10"></textarea>
<input type="submit" name="" id="" onclick="AutoLink()">
</form>

<p>↓結果</p>
<div id="js-result"></div>

<script>
function AutoLink() {
var str = document.getElementById('js-text').value
var regexp_url = /((h?)(ttps?:\/\/[a-zA-Z0-9.\-_@:/~?%&;=+#',()*!]+))/g; 
var regexp_makeLink = function(all, url, h, href) {
return '<a href="h' + href + '" target="_blank">' + url + '</a>';
}
var textWithLink = str.replace(regexp_url, regexp_makeLink);
document.getElementById('js-result').innerHTML = textWithLink
}
</script>
</body>
</html>