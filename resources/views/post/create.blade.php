@extends('layouts.app')
@section('content')
    <h2 class="mt-5">新規投稿</h2>
    <form method="POST" action="{{ route('post.store') }}">
        @csrf
        <div class="form-group mt-5 p-0">
            <div class="form-group col-sm-2 p-0 m-0">
                <p><span class="text-Danger">日付</span>を入力</p>
                <input id="date" type="date" class="form-control" placeholder="日付を選択してください。" name="date" value="<?php echo date('Y-m-d'); ?>">
            </div>

            <div class="form-group">
                <label for="title" class="mt-3">内容</label>
                <input id="potstcpntet" type="text" class="form-control"  placeholder="投稿内容は２５５文字まで" name="postcontent" value="{{ old('postcontent') }}">
            </div>
            <button type="submit" class="btn btn-primary mt-5 mb-5">投稿する</button>
        </div>
    </form>
    <h2 class="mt-5">一つ前の投稿済みコンテンツ</h2>
    @include('post.posts', ['posts' => $posts , "user => $user"])
@endsection