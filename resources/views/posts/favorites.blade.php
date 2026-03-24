@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-8 offset-sm-2 text-center">
            <h3 class="mb-4">「いいね」をしてくれた人一覧</h3>
            
            @if($favoriteUsers->isEmpty())
                <p>まだ「いいね」した人はいません。</p>
            @else
                <ul class="list-unstyled">
                    @foreach($favoriteUsers as $user)
                        <li class="mb-4 d-flex align-items-center justify-content-center">
                            <a href="{{ route('user.show', $user->id) }}">
                                <img class="mr-3 rounded-circle" src="{{ Gravatar::src($user->email, 50) }}" alt="ユーザのアバター画像">
                            </a>
                            <div class="text-left" style="width: 250px;">
                                <h5 class="mt-0 mb-1"><a href="{{ route('user.show', $user->id) }}">{{ $user->name }}</a></h5>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="d-flex justify-content-center">
                    {{ $favoriteUsers->links() }}
                </div>
            @endif
            
            <a href="javascript:history.back()" class="btn btn-outline-secondary mt-4">元のページに戻る</a>
        </div>
    </div>
@endsection
