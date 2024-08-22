{{-- @extends('layouts.app') --}}
{{-- @section('content') --}}
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title></title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('/css/styles.css') }}">
</head>
<div class="row">
    <aside class="col-sm-4 mb-5">
        <div class="card bg-info">
            
            <div class="card-header">
                <h3 class="card-title text-light">{{ $user->name }}</h3>
            </div>
            <div class="card-body">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($user->email, 300) }}" alt="ユーザのアバター画像">
                @if (Auth::id() == $user->id)
                    <div class="mt-3">
                        <a href="{{-- {{ route('user.edit') }} --}}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                    </div>
                @endif
            </div>
        </div>
    </aside>
    <div class="col-sm-8">
        <ul class="nav nav-tabs nav-justified mb-3">
            <li class="nav-item"><a href="" class="nav-link {{ Request::is() ? 'active' : '' }}">タイムライン</a></li>
            <li class="nav-item"><a href="#" class="nav-link">フォロー中</a></li>
            <li class="nav-item"><a href="#" class="nav-link">フォロワー</a></li>
        </ul>
    </div>
</div>
{{-- @endsection --}}