@extends('layouts.app')
@section('content')

    @if(Auth::check())
    <p class="text-right mr-3 pb-3">
        ユーザー：<span class="user-name">{{ Auth::user()->name }}</span>
    </p>
    @endif

    <div class="d-flex flex-column">

    @if (Auth::check())
        
        <div><a class="btn btn-primary btn-lg" href="{{ route("post.create")}}" role="button">新規投稿</a></div>

    @else
    <div class="d-flex">
       <a href="{{ route('login') }}" class="nav-link p-0">ログイン</a> または <a href="{{ route('signup') }}" class="nav-link p-0">新規ユーザ登録</a>  後に投稿できます。
    </div>
    @endif

    @if (Auth::user() )
    <table class="table thead-light table-bordered table-hover my-2">
        <tr class="text-center bg-dark text-white"><th style="width: 13%">日付</th><th>内容</th><th style="width: 10%">削除</th><th style="width: 10%">編集</th></tr>
        @foreach($posts as $recode)
        
        <tr>
            <td  class="text-center">{{$recode -> date}}</td>
            <td>{{$recode -> postcontent}}</td>
            <td>
                <form method="POST" action="{{ route('post.delete', $recode->id) }}">
                @csrf
                @method('DELETE')
                <div class="text-center"><button type="submit" class="btn btn-danger btn-sm">削除</button></div>

                </form>
            </td>
            <td>
             <div class="text-center"><button type="submit" class="btn btn-success btn-sm"><a href="{{ route('post.edit', $recode->id) }}" class="text-white text-decoration-none">編集</button></div>
            </td>
        </tr>
        @endforeach
    </table>
    @else
    <div>ログイン後、投稿を見れます。</div>

    @endif

    </diV>


@endsection