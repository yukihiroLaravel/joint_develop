@php
    require_once app_path('Helpers/ViewHelper.php');
    $viewHelper = \App\Helpers\ViewHelper::getInstance();

    //「$followsParam」を作成する。
    $followsParam = $viewHelper->createFollowsParam($user);
@endphp
@foreach ($posts as $post)
    @include('posts.show', ['user' => $user, 'post' => $post, 'followsParam' => $followsParam])
@endforeach
{{ $posts->links('pagination::bootstrap-4') }}
