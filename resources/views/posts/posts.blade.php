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
                    <img class="mr-2 rounded-circle" src="{{ Gravatar::src ($user->email,55) }}" alt="ユーザのアバター画像">
                    <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show',$user->id) }}">{{ $user->name }}</a></p>
            </div>
            <div class="container">
                <div class="text-left d-inline-block w-75">
                    <p class="mb-2">{{ $post->text}}</p>
                    <p class="text-muted">{{ $post->created_at }}</p>
                </div>
                @if (Auth::check() && Auth::id() === $post->user_id)
                    <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                        <form action="{{ route('post.delete', $post->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                        <a href="" class="btn btn-primary">編集する</a>
                    </div>
                @endif
            </div>
        </li>
    @endforeach
</ul>
<div class="m-auto" style="width: fit-content">{{ $posts->links() }}</div>
