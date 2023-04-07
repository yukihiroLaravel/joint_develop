@extends('layouts.app')
@section('content')
<h2 class="mt-5">投稿を編集する</h2>
    <form method="POST" action="">
        <div class="form-group">
            <textarea id="content" class="form-control" name="post_edit" rows=""></textarea>
        </div>
        <button type="submit" class="btn btn-primary">更新する</button>
    </form>
@endsection