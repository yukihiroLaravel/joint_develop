@extends('layouts.tab')
@section('tab')
<ul class="list-unstyled">
    @foreach($user->posts()->get() as $post)
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($user->email, 55) }}" alt="ユーザのアバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="">{{ $user->name }}</a></p>
            </div>
            <div class="">
                <div class="text-left d-inline-block w-75">
                    <p class="mb-2">{{ $post->content }}</p>
                    <p class="text-muted">{{ $post->created_at }}</p>
                </div>
                @if (Auth::id() === $user->id)
                    <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                        <form method="POST" action="{{ route('posts.delete', $post->id) }}">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">編集する</a>
                    </div>
                @endif
            </div>
        </li>
    @endforeach
</ul>
@endsection
