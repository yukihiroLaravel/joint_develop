{{-- 詳細検索フォーム --}}
@extends('layouts.app')
@section('content')
    <div class="container">
        <h2 class="mt-5 mb-3">投稿を検索する</h2>

        <form method="GET" action="{{ route('search.index') }}">
            @csrf
            <div class="form-group">
                <label for="searchContent">投稿内容 :</label>
                <input type="text" class="form-control" id="searchContent" name="searchContent" value="{{ old('searchContent') }}" placeholder="キーワードで検索">
            </div>

            <div class="form-group">
                <label for="searchUserName">ユーザ :</label>
                <input type="text" class="form-control" id="searchUserName" name="searchUserName" value="{{ old('searchUserName') }}" placeholder="ユーザ名で検索">
            </div>

            <div class="form-group">
                <label for="startDate">投稿日（〇/〇日以降～） :</label>
                <input type="date" class="form-control" id="startDate" name="startDate" value="{{ old('startDate') }}">
            </div>

            <div class="form-group">
                <label for="endDate">投稿日（～〇/〇日まで）  :</label>
                <input type="date" class="form-control" id="endDate" name="endDate" value="{{ old('endDate') }}" >
            </div>

            <button type="submit" class="btn btn-primary">検索</button>
        </form>
    </div>
@endsection
