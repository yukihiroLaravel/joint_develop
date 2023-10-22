@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>検索結果【検索ワード： {{ $searchQuery }}】</h1>
        @if($searchResults->count() > 0)
            @foreach ($searchResults as $post)
                <ul class="list-unstyled">
                    <li class="mb-3 text-center">
                        <div class="text-left d-inline-block w-75 mb-2">
                            <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
                                <p class="mt-3 mb-0 d-inline-block"><a  href="{{ route('users.show',$post->user_id) }}">{{ $post->user->name }}</a></p>
                        </div>
                        <div class=""> 
                            <div class="text-left d-inline-block w-75">
                                <p class="mb-2">{!! preg_replace(
                                    '/(' . preg_quote($searchQuery, '/') . ')/i', 
                                    '<span style="background-color: yellow;">$1</span>', 
                                    $post->content
                                ) !!}</p>
                                <p class="text-muted">{{ $post->created_at }}</p>
                            </div>
                            @if(Auth::check() && Auth::id() == $post->user_id)
                                <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                                    <form method="POST" action="{{ route('post.delete', $post->id) }}" id="delete-form">
                                        @csrf
                                        @method('DELETE')
                                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">削除</button>
                                    </form>
                                        <script>
                                            function confirmDelete() {
                                                if (confirm('本当に削除しますか？')) {
                                                    document.getElementById('delete-form').submit();
                                                } else {
                                                    return back();
                                                }
                                            }
                                        </script>
                                    <a href="{{ route('post.edit',$post->id) }}" class="btn btn-primary">編集する</a>
                                </div>
                            @endif
                        </div>
                    </li>
                </ul>
            @endforeach
            <div class="m-auto" style="width: fit-content">{{ $searchResults->links('pagination::bootstrap-4') }}</div>
        @else
            <p>検索条件に一致する投稿は見つかりませんでした。</p>
        @endif
    </div>
@endsection