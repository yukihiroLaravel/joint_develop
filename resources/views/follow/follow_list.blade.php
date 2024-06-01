@extends('layouts.app')
@section('content')
<div class="row">
    <aside class="col-sm-4 mb-5">
        @include('layouts.user_profile', ['user' => $user])
    </aside>
    <div class="col-sm-8">
        @include('layouts.user_nav_tabs', ['user' => $user, 'counts' => $counts])
        @include('follow.user_list', ['users' => $users])
    </div>
</div>
@endsection
