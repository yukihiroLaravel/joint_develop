{{-- 詳細検索フォーム --}}
@extends('layouts.app')
@section('content')
    <div class="container">
        <h2 class="mt-5 mb-3">投稿を検索する</h2>

        <form method="POST" action="{{ route('search.search') }}">
            @csrf
            <div class="form-group">
                <label for="param1">投稿内容 :</label>
                <input type="text" class="form-control" id="param1" name="param1" value="{{ old('param1') }}" placeholder="キーワードで検索">
            </div>

            <div class="form-group">
                <label for="param2">ユーザ :</label>
                <input type="text" class="form-control" id="param2" name="param2" value="{{ old('param2') }}" placeholder="ユーザ名で検索">
            </div>

            <div class="form-group">
                <label for="param3">投稿日（〇/〇日以降～） :</label>
                <input type="date" class="form-control" id="param3" name="param3" value="{{ old('param3') }}">
            </div>

            <div class="form-group">
                <label for="param4">投稿日（～〇/〇日まで）  :</label>
                <input type="date" class="form-control" id="param4" name="param4" value="{{ old('param4') }}" >
            </div>

            <button type="submit" class="btn btn-primary">検索</button>
        </form>
    </div>
@endsection
