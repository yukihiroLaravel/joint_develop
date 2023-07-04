@extends('layouts.app')
@section('title', 'ユーザー詳細ページ')
@section('description', 'ユーザー情報の閲覧ができます。')
@section('content')
    @include('commons.flash_message')
    <div class="row">
        <aside class="col-sm-4 mb-5">
            @include('users.user_icon')
        </aside>
        <div class="col-sm-8">
            @include('commons.tab')
            @include('posts.posts')
        </div>
    </div>
@endsection
