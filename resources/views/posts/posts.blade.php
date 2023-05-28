@foreach ($users as $user)
{{--10件表示してページ変更予定、まだ未完成--}}
@if ($loop->iteration % 10 === 1 && $loop->iteration !== 1)
</div>
<div class="row text-center mt-3">
@endif

<ul class="list-unstyled">
    <li class="mb-3 text-center">
        <div class="text-left d-inline-block w-75 mb-2">
           @if($user->email)
            <img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 55) }}"
                alt="{{ $user->name }}アバター画像">
            <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $user->id) }}">{{ $user->name }}</a></p>
        @endif
        </div>
        <div class="">
            <div class="text-left d-inline-block w-75">
                <p class="mb-2">投稿内容{{--{{ $posts->text }}--}}</p>
                <p class="text-muted">投稿時間{{--{{ $posts->updated_at }}--}}</p>
            </div>
            @if ($user->id === Auth::id() )
            <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                <form method="" action="">
                    <button type="submit" class="btn btn-danger">削除</button>
                </form>
                <a href="{{ route('edit',Auth::id()) }}" class="btn btn-primary">編集する</a>
            </div>
            @endif
        </div>
    </li>
</ul>
@endforeach
<div class="m-auto" style="width: fit-content"></div>
{{--{{ $posts->links(‘pagination::bootstrap-4’) }}--}}