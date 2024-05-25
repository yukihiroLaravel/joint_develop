@extends('layouts.app')
@section('content')
<div class="text-center mb-3">
            <ul class="nav nav-tabs nav-justified mb-3">
            <li class="nav-item">コメント一覧</li>
            </ul>
            <ul>
                @foreach ($comments as $comment)
                    <li>
                        <a href="{{ route('comments.show', $comment->id) }}">
                            {{ $comment->content }}
                        </a>
                    </li>
                @endforeach
            </ul>
            <!-- コメント投稿機能 -->
            <h1>コメント投稿</h1>
            <div>
                <form method="post" action="{{ route('comments.store') }}">
                    @csrf
                    <p>
                        <label for="content">content: </label>
                        <textarea name="content" id="content" rows="4" cols="60" >{{ old('content') }}</textarea>
                        @if ($errors->has('content'))
                            <span class="error">{{ $error->first('content') }}</span>
                        @endif
                    </p>
                    <p>
                        <input type="submit" value="投稿">
                    </p>
                </form>
            </div>
</div>
        
@endsection
