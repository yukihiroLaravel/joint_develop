{{-- @extends('layouts.app') --}}
{{-- @section('content') --}}
<div class="row">
    <aside class="col-sm-4 mb-5">
        <div class="card bg-info">
            @if (session('error'))
                <div class="alert alert-danger mt-3">
                    {!! session('error') !!}
                </div>
            @endif
            <div class="card-header">
                <h3 class="card-title text-light">{{ $user->name }}</h3>
            </div>
            <div class="card-body">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($user->email, 300) }}" alt="ユーザのアバター画像">
                @if (Auth::id() === $user->id)
                    <div class="mt-3">
                        <a href="{{-- {{ route('user.edit') }} --}}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                    </div>
                    <div class="mt-3">
                        <form method="POST" action="{{ route('user.delete', $user->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" data-user-name="{{ $user->name }}" data-user-email="{{ $user->email }}">退会する</button>
                        </form>
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
<script src="{{ asset('/js/confirmDelete.js') }}" defer></script>
{{-- @endsection --}}