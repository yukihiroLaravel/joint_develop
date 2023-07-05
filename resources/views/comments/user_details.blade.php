@extends('layouts.app')
@section('content')
<div class="row">
    <aside class="col-sm-4 mb-5">
        @include('users.user_card')
    </aside>
    <div class="col-sm-8">
        @include('users.user_tab')
        @include('comments.comment_list')
        <div class="m-auto" style="width: fit-content">{{ $comments->links('pagination::bootstrap-4') }}</div>
    </div>
</div>
@endsection